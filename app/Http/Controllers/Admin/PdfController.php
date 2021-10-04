<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Illuminate\Http\Request;
use App\helpers\DbTables\Constants\Constants;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Tinturas;
use App\Models\Toallera;
use Illuminate\Support\Facades\Storage;
use App\Models\CCPdf;


class PdfController extends Controller
{
    const RULES = [
        "minRange" =>["required", "numeric", "lte:maxRange", "not_in:0", "gt:0"],
        "maxRange" =>[ "required", "numeric", "gte:minRange", "not_in:0", "gt:0"],
        "denomination" =>["required","string","regex:/TOALLERA|TINTURA/"]
    ];
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
        ->get());
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
        if(Toallera::get()->count() == Constants::EMPTY 
            || Tinturas::get()->count() == Constants::EMPTY){
                return redirect()->back();
        }
        $validaton = Validator::make($response, self::RULES);  
        if($validaton->fails()){
            $validaton->errors()->add('error_input', 'error text');
            return redirect()->back()->withInput()->withErrors($validaton);
        }
        $pdf = CCPdf::where( "minRange", $response["minRange"])
                ->where("maxRange", $response["maxRange"])
                ->where("denomination",$response["denomination"])
                ->get();
        $pdfName = $this->getPdfName($response);
        $credentialsPath =  public_path('credentials/');
        if($pdf->count() == Constants::EMPTY){
            $denomination = $response["denomination"];
            $workers = $this->getWorkerData($request);
            $pdf = PDF::loadView("admin.pdf.credentials", compact("workers", "denomination"));
            $this->insertPdfData($response);
            $pdf->save($credentialsPath.$pdfName);
            return $pdf->stream($pdfName);
        }
        return redirect("/credentials/{$pdf->first()->pdfName}");
        
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
