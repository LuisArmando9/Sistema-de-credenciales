<?php

namespace App\Http\Controllers\Admin;

use App\helpers\Csv\Constants\Constants;
use App\helpers\Csv\Constants\Table;
use App\helpers\Name;
use App\Http\Controllers\Admin\Rules\CredentialRules;
use App\Http\Controllers\Controller;
use App\Models\CCPdf;
use App\View\Components\Admin\Modal\CredentialInfo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CredentialController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getCredential($text, $denomination){
        if(empty($text)){
            return null;
        }
        if(is_numeric($text)){
            return DB::table($denomination)->where("id", $text)->get()->first();
        }elseif(Name::isValid($text)){
            return DB::table($denomination)->where("worker",'like', '%'.$text.'%' )->get()->first();
        }else {
            return  null;
        }

    }
    public function index(Request $request)
    {
        if(Constants::isEmpty($request->all())){
            return back();
        }
        $response = $request->except(["_token"]);
        $validaton = Validator::make($response, CredentialRules::RULES);
        if($validaton->fails()){
            $validaton->errors()->add('credentialInfo', 'errors');
            return redirect()->back()->withInput()->withErrors($validaton);
        }
        $text = $request->get("credential-search");
        $denomination = strtolower($request->get("denomination"));
        $worker = $this->getCredential($text, $denomination);

        if(is_null($worker)){
            return back()->with("toast_error", "Ocurrio un error al buscar, verifiqué sus campos");
        }
        $credentials = CCPdf::where("folio", $worker->id)->where("denomination", $denomination)->get(["pdfName", "created_at"]);
        $view = view("admin.credential.index")
            ->with("worker", $worker->worker);
        if($credentials->count() == Constants::EMPTY){
            return $view
            ->with("credentialIsFinded", false);
        }
        return $view
        ->with("credentialIsFinded", true)
        ->with("credentials",  $credentials );
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
