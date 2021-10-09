<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Departament;
use App\Models\Denomination;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Rules\CsvRules;
use App\helpers\Csv\CSVDepartament;
class DepartamentController extends Controller
{
    const RULES = [
        "departamentName" => 'required|alpha_spaces',
        "denominationId" => 'required|numeric'
    ];
    const MAX_PAGINATION = 20;
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
        return view("admin.departament.index")
        ->with("departaments",  
        Departament::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Denomination::isEmpty())
        {
            return view("admin.error")
            ->with("MessageOfEmptyTable", "No hay registros alguna razón social, debe registrar al menos una razon social.");
        }
        return view("admin.departament.create")
        ->with("denominations", Denomination::get());
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
        try {
            Departament::create($response);
        } catch (\Illuminate\Database\QueryException $th) {
            return redirect()->route('departament.create')->with("_INSERT", "_IS_NOT");
        }     
        return redirect()->route('departament.index')  
        ->with("INSERT", "IS_OK");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departament  $departament
     * @return \Illuminate\Http\Response
     */
    public function show(Departament $departament)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Departament  $departament
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $departament = Departament::findOrfail($id);
        return view("admin.departament.edit")
        ->with("denominations", Denomination::get())
        ->with("departament", $departament);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Departament  $departament
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Departament::findOrfail($id);
        $request->validate(self::RULES);
        $response = $request->except(['_token', "_method"]);
        Departament::where('id', '=', $id)->update($response);
        return redirect()->route('departament.index')
        ->with("UPDATE", "IS_OK");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departament  $departament
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){

        $departmanet = Departament::findOrfail($id);
        try {
            $departmanet->delete();
        } catch (\Illuminate\Database\QueryException  $th) {
            return redirect()->route('departament.index')->with("DELETE_ERROR", "IS_OK")
            ->with("Name", $departmanet->departamentName );
        }
        return redirect()->route('departament.index')->with("DELETE", "IS_OK");
    }
     /**
     * Upload the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
       $request->validate(CsvRules::RULES);
       
       try {
            $path = $request->file("cvs_file")->getRealPath();
            $departamentImport = new CSVDepartament($path);
            $departamentImport->insert();
       } catch (\Exception $th) {
            return redirect()
            ->route('departament.index')
            ->with("UPLOAD_ERROR", "IS_OK")
            ->with("message", $th->getMessage());
       }
       return redirect()
            ->route('departament.index')
            ->with("UPLOAD_SUCCESS", "IS_OK");
    }
}
