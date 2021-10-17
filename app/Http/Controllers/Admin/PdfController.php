<?php

namespace App\Http\Controllers\Admin;

use App\helpers\Csv\Constants\Constants;
use App\Http\Controllers\Admin\Rules\PdfRules;
use Illuminate\Http\Request;
use App\helpers\Csv\Constants\Table;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\CCPdf;
use App\helpers\Pdf\HPDF;

class PdfController extends Controller
{
   
     
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
    private function getPdfName($workers, $denomination)
    {
        $date = date('Y-h-m');
        $minRange = $workers->first()->id;
        if($workers->count() == Constants::MIN_RESULT){
            return "credencial-{$minRange}-{$date}-$denomination .pdf";
        }
        $maxRange =  $workers->last()->id;
        return  "credenciales-{$minRange}-{$maxRange}-{$date}-{$denomination}.pdf";
    }
    private function getWorkerData(Request $request){
        $response = $request->all();
        $workerTable = strtolower($response["denomination"]);

        if($this->areEqualRanges($response)){
            return DB::table($workerTable)
            ->where("id", $response["minRange"])->get();
        }
        $offset = $response["maxRange"] -$response["minRange"];
        return DB::table($workerTable)
        ->where("id", ">=", $response["minRange"])
        ->skip(0)
        ->take($offset)
        ->get();
    }
   
    private function insertPdfData($workers, $pdfName, $denomination){

        if($workers->count() == Constants::MIN_RESULT)
        {
            $credentialsNumber = Constants::MIN_RESULT;
            $minRange = $workers->first()->id;
            $maxRange =  $minRange;
        }else{
            $minRange = $workers->first()->id;
            $maxRange = $workers->last()->id;
            $credentialsNumber =  ($maxRange -  $minRange)+1;
        }
        CCPdf::create([
            "pdfName" => $pdfName,
            "minRange" =>  $minRange,
            "maxRange" =>  $maxRange,
            "credentialsNumber" =>  $credentialsNumber,
            "denomination" => $denomination
        ]);

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
        $denomination = strtolower($response["denomination"]);
        if(Table::isEmpty($denomination)){
            return redirect()->back()
            ->with("toast_error", "La tabla {$denomination} se encuentra vacia.");
        }
        $workers = $this->getWorkerData($request);
        if($workers->count() > HPDF::MAX_CREDENTIALS){
            return redirect()->back()->with("toast_error", 
            "El número máximo de credenciales son 50.");
        }
        if($workers->count() == Constants::EMPTY){
            return redirect()->back()->with("toast_error", 
            "Los folio(s) estan vaciós.");
        }
        $pdf = new HPDF($workers, $denomination);
        $pdf->writePdfCredential();
        $pdfName = $this->getPdfName($workers, $denomination);
        $this->insertPdfData( $workers, $pdfName, $denomination);
        return $pdf->getOutput($pdfName);

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
