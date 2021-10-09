<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Illuminate\Http\Request;
use App\helpers\Csv\Constants\Table;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\CCPdf;
use App\helpers\Pdf\HPDF;

class PdfController extends Controller
{
    const RULES = [
        "minRange" =>["required", "numeric", "lte:maxRange", "not_in:0", "gt:0"],
        "maxRange" =>[ "required", "numeric", "gte:minRange", "not_in:0", "gt:0"],
        "denomination" =>["required","string","regex:/TOALLERA|TINTURA/"]
    ];
    const CREDENTIAL_INCREMENT = 70;
    public function __construct()
    {
        $this->middleware(['role:ADMIN', 'auth']);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view("admin.pdf.credentials")->with("workers", DB::table("tintura")
        ->skip(0)
        ->take(19)
        ->get())->with("denomination", "Tintura");
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
    private function getPdfName($data)
    {
        $date = date('Y-h-m');
        $denomination = $data["denomination"];
        if($this->areEqualRanges($data)){
            return "credencial-{$data['minRange']}-{$date}-{$denomination}.pdf";
        }
        return  "credenciales-{$data['minRange']}-{$data['maxRange']}-{$date}-{$denomination}.pdf";
    }
    private function getWorkerData(Request $request){
        $response = $request->all();
        $workerTable = strtolower($response["denomination"]);

        if($this->areEqualRanges($response)){
            return DB::table($workerTable)
            ->where("id", $response["minRange"])->get();
        }
        $start = (int)$response["minRange"];
        $offset = (int)$response["maxRange"] - $start;
        return DB::table($workerTable)
        ->skip($start-1)
        ->take($offset)
        ->get();
    }
   
    private function insertPdfData($data){
        $minRange = (int) $data["minRange"];
        $maxRange = (int) $data["maxRange"];
        if($minRange == $maxRange){
            $credentialsNumber = 1;
        }
        $credentialsNumber =  $maxRange -  $minRange ;
        var_dump($this->getPdfName($data));
        CCPdf::create([
            "pdfName" => $this->getPdfName($data),
            "minRange" =>  $minRange,
            "maxRange" =>  $maxRange,
            "credentialsNumber" =>  $credentialsNumber,
            "denomination" => $data["denomination"]
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
        $validaton = Validator::make($response, self::RULES);  
        if($validaton->fails()){
            $validaton->errors()->add('error_input', 'error text');
            return redirect()->back()->withInput()->withErrors($validaton);
        }
        $denomination = $response["denomination"];
        if(Table::isEmpty($denomination)){
            return redirect()->back();
        }
        $pdfName = $this->getPdfName($response);
        $workers = $this->getWorkerData($request);
        if($workers->count() > HPDF::MAX_CREDENTIALS){
            return redirect()->back()->with("PRINT_FAIL", "IS_OK");
        }
        $pdf = new HPDF($workers, $denomination);
        $pdf->writePdfCredential();
        $this->insertPdfData($response);
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
