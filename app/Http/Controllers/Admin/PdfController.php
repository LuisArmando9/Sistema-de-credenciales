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
        
        $pdf = new HPDF($workers, $denomination);
        $pdf->writePdfCredential();
        $pdfName = $this->getPdfName($workers, $denomination);
        header('Content-type: application/pdf');
        return $pdf->getOutput($pdfName);
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
        $workers = $this->getDataPerOneWorker($response);
        
        DB::beginTransaction();
        try{
            $workers = $this->getDataPerOneWorker($response);
            CCPdf::create([
                "pdfName" => $this->getPdfName($workers,  $response["denomination"]),
                "denomination" => $response["denomination"],
                "folios"=> $this->getFolios($workers),
                "credentialsNumber" => $workers->count()
            ]);
            DB::commit();
            return $this->getPdf($workers, $response["denomination"]);
          
        }catch(Exception $ex){
            DB::rollback();
            return redirect()->back()
            ->with("toast_error", $ex->getMessage());
        }
    }
    private function getPdfPerWorkerRanges(Request $request){
        $validator = Validator::make($request->all(), PdfRules::RULES_PER_RANGES);
        if($validator->fails()){
            return redirect()->back()->with("toast_error", "<small>No se puede imprimir, contienes errores.</small>")
            ->withErrors($validator);
        }
        $response = $request->all();
        DB::beginTransaction();
        try{
            $workers = $this->getDataPerRanges($response["minRange"], 
            $response["maxRange"], 
            strtolower($response["denomination"]));
            CCPdf::create([
                "pdfName" => $this->getPdfName($workers,  $response["denomination"]),
                "denomination" => $response["denomination"],
                "folios"=> $this->getFolios($workers),
                "credentialsNumber" => $workers->count()
            ]);
            DB::commit();
            return $this->getPdf($workers, $request->post("denomination"));
        }catch(Exception $ex){
            return redirect()->back()
            ->with("toast_error", $ex->getMessage());

        }
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
