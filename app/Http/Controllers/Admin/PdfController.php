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
 
    private function areEqualRanges($data){
        return $data["minRange"] == $data["maxRange"];
    }
    private function getPdfName($id)
    {
        return  "{$id}.pdf";
    }
    private function getPdf($worker, $denomination){
        $pdf = new HPDF($worker, $denomination);
        $pdf->writePdfCredential();
        $pdfName = $this->getPdfName($worker->id, $denomination);
        header('Content-type: application/pdf');
        return $pdf->getOutput($pdfName);

    }
    private function getWorkerData($response){
        $denomination = strtolower($response["denomination"]);
        if(Table::isEmpty($denomination)){
            throw new Exception("La tabla {$denomination} se encuentra vacia.");
        }
        $name = $response["name"];
        if(Name::isValid( $name)){
            $worker = DB::table($denomination)->where("worker",'like', '%'. $name.'%' )->get()->first();
            
        }elseif(is_numeric($name)){
            $worker = DB::table($denomination)->where("id", $name)->get()->first();
        }else{
            throw new Exception("El elemento {$name} es incorrecto, deber ser id o nombre completo");
        }
        if(is_null($worker)){
            throw new Exception("El nombre {$name} no se encuentra.");
        }
        return $worker;

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $response = $request->all();
        $validaton = Validator::make($response, PdfRules::RULES);  
        if($validaton->fails()){
            $validaton->errors()->add('error_input', 'error text');
            return redirect()->back()->withInput()->withErrors($validaton);
        }
        DB::beginTransaction();
        try{
            $worker = $this->getWorkerData($response);
            CCPdf::create([
                "pdfName" => $this->getPdfName($worker->id,  $response["denomination"]),
                "denomination" => $response["denomination"],
                "folio"=> $worker->id
            ]);
            DB::commit();
            return $this->getPdf($worker, $response["denomination"]);
          
        }catch(Exception $ex){
            DB::rollback();
            return redirect()->back()
            ->with("toast_error", $ex->getMessage());
        }
        
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
