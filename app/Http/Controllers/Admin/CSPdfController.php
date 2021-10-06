<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\helpers\DbTables\Constants\Constants;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Tinturas;
use App\Models\Toallera;
use Illuminate\Support\Facades\Storage;
use App\Models\CCPdf;
use Illuminate\Support\Facades\View;
use Response;
class CSPdfController extends Controller
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
            
           return Response::json($validaton->errors());
            
            //return redirect()->back()->withInput()->withErrors($validaton);
        }
        $pdfName = $this->getPdfName($response);
        $credentialsPath =  public_path('credentials/');
        $denomination = $response["denomination"];
        $workers = $this->getWorkerData($request);
        $html = View::make("admin.pdf.credentials")->render();
        return Response::json(["view" => $html]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CSPdf  $cSPdf
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CSPdf  $cSPdf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CSPdf  $cSPdf
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
    }
}