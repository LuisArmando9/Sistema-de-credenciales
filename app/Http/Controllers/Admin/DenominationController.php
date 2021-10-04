<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Rules\CsvRules;
use App\Http\Controllers\Controller;
use App\Models\Denomination;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Rules\CvsRules;
use App\helpers\DbTables\DBDenomination;
class DenominationController extends Controller
{
    const RULES = [
        "denominationName" => 'required|alpha_spaces'
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
        $denominations = Denomination::all();
        return view("admin.denomination.index")->with('denominations', $denominations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view("admin.denomination.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(self::RULES);
        $response = $request->except(['_token']);
        Denomination::create( $response);
        return redirect()->route('denomination.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Denomination  $denomination
     * @return \Illuminate\Http\Response
     */
    public function show(Denomination $denomination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Denomination  $denomination
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $denomination = Denomination::findOrfail($id);
        return view("admin.denomination.edit")->with('denomination', $denomination);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Denomination  $denomination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Denomination::findOrfail($id);
        $request->validate(self::RULES);
        $response = $request->except(['_token', "_method"]);
        Denomination::where('id', '=', $id)->update($response);
        return redirect()->route('denomination.index') 
        ->with("UPDATE", "IS_OK");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Denomination  $denomination
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){

        $denomination = Denomination::findOrfail($id);
        try {
                $denomination->delete();
        } catch (\Illuminate\Database\QueryException  $th) {
                return redirect()->route('denomination.index')->with("DELETE_ERROR", "IS_OK")
                ->with("Name", $denomination->denominationName );
        }
       return redirect()->route('denomination.index')->with("DELETE", "IS_OK");

    }
    /**
     * Upload the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $request->validate(CsvRules::RULES);
        $path = $request->file("cvs_file")->getRealPath();
        try{
            $denominationImport = new DBDenomination($path);
            $denominationImport->insert();
        }catch(\Exception $th){
            
            return redirect()->route('denomination.index')
            ->with("UPLOAD_ERROR", "IS_OK")
            ->with("message", $th->getMessage());
        }
        return redirect()->route('denomination.index')
            ->with("UPLOAD_SUCCESS", "IS_OK");
    }
}
