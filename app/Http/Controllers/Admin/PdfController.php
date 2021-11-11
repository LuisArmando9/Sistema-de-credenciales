<?php

namespace App\Http\Controllers\Admin;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\helpers\Csv\Constants\Constants;
use App\Http\Controllers\Admin\Rules\PdfRules;
use Illuminate\Http\Request;
use App\helpers\Csv\Constants\Table;
use App\helpers\Name;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\CCPdf;
use App\helpers\Pdf\HPDF;
use Exception;
use Faker\Core\Number;


class PdfController extends Controller
{
    const FILE_NAME = "/credentials/template_for_credential.jpg";
     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    private function getFolios($workers){
        $folios = "";
        foreach ($workers as $worker) {
            $folios .= $worker->id . " ";
        }
        return trim($folios);
    }
    private function getPdfName($workers)
    {
        if($workers->count() == 1){
            $ids = $workers->first()->id;
        }else{
            $ids = "{$workers->first()->id}-{$workers->last()->id}";
        }
        return "{$ids}.pdf";
    }
    private function getPdf($workers, $denomination){
        
        DB::beginTransaction();
        try{
            $denomination = strtolower($denomination);
            $pdf = new HPDF($workers, $denomination);
            $pdf->writePdfCredential();
            $pdfName = $this->getPdfName($workers, $denomination);
            CCPdf::create([
                "pdfName" => $this->getPdfName($workers,  $denomination),
                "denomination" => $denomination,
                "folios"=> $this->getFolios($workers),
                "credentialsNumber" => $workers->count()
            ]);

            DB::commit();
            header('Content-type: application/pdf');
            return $pdf->getOutput($pdfName);
          
        }catch(Exception $ex){
            DB::rollback();
            return redirect()->back()
            ->with("toast_error", $ex->getMessage());
        }
    }
    private function getDataPerDepartament(Request $request){
        if(!$request->has('denomination') && !Table::isWorkerTable($request->post('denomination'))){
            return back();
        }
        $response = $request->all();
        $denomination = strtolower($response['denomination']); 
        $request->validate([ 'departament' => "required|exists:{$denomination},departamentId"]);
        return DB::table($denomination)
         ->where("departamentId", $response['departament'] )->get();
     


    }
    private function getAll(Request $request){
        $request->validate(PdfRules::RULES_FOR_ALL_WORKERS);
        $denomination = strtolower($request->all()["denomination"]);
        return DB::table($denomination)->get();

    }
    private function getDataPerOneWorker($response){
        $denomination = strtolower($response["denomination"]);
        if(Table::isEmpty($denomination)){
            throw new Exception("La tabla {$denomination} se encuentra vacia.");
        }
        $name = $response["name"];
        if(Name::isValid( $name)){
            $worker = DB::table($denomination)->where("worker",'like', '%'. $name.'%' )->get();
            
        }elseif(is_numeric($name)){
            $worker = DB::table($denomination)->where("id", $name)->get();
        }else{
            throw new Exception("El elemento {$name} es incorrecto, deber ser id o nombre completo");
        }
        if(is_null($worker)){
            throw new Exception("El nombre {$name} no se encuentra.");
        }
        return $worker;
    }
    private function getDataPerRanges($min, $max, $workerTable){
        $offset = $max - $min;
        return DB::table($workerTable)
        ->where("id", ">=", $min)
        ->skip(0)
        ->take($offset)
        ->get();

    }
    private function getPdfPerOneWorker(Request $request){
        $response = $request->all();
        $validaton = Validator::make($response, PdfRules::RULES_PER_ONE_WORKER);  
        if($validaton->fails()){
            $validaton->errors()->add('error_input', 'error text');
            return redirect()->back()->withInput()->withErrors($validaton);
        }
        try{
            $workers = $this->getDataPerOneWorker($response);
            return $this->getPdf($workers, $request->all()["denomination"]);
        }catch(Exception $ex){
            return redirect()->back()
            ->with("toast_error", $ex->getMessage());
        }
    }
    private function getPdfPerWorkerRanges(Request $request){
        $response  = $request->all();
        $validator = Validator::make( $response , PdfRules::RULES_PER_RANGES);
        if($validator->fails()){
            return redirect()->back()->with("toast_error", "<small>No se puede imprimir, contienes errores.</small>")
            ->withErrors($validator);
        }
        $workers = $this->getDataPerRanges($response["minRange"], 
        $response["maxRange"], 
        strtolower($response["denomination"]));
        return $this->getPdf($workers, $response["denomination"]);
       
    }
    private function getPdfPerDenomination(Request $request){
        return $this->getPdf($this->getAll($request), 
                    $request->all()["denomination"]);
    }
    private function getPdfPerDepartament(Request $request){
        return $this->getPdf($this->getDataPerDepartament($request), $request->all()["denomination"]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if($request->has('name')){
           return $this->getPdfPerOneWorker($request);
       }
       elseif($request->has('minRange') && $request->has('maxRange')){
           return $this->getPdfPerWorkerRanges($request);
       }elseif($request->has("type")){
            return $this->getPdfPerDenomination($request);
       }elseif($request->has("departament")){
            return $this->getPdfPerDepartament($request);
       }
       return back();   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
