<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Tinturas;
use App\Models\Departament;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Rules\CsvRules;
use App\helpers\DbTables\DBTinturas;
use App\Http\Controllers\Admin\ToalleraController;


/**
 * https://stackoverflow.com/questions/32810385/laravel-preg-match-no-ending-delimiter-found
 * CURP: https://es.stackoverflow.com/questions/31039/c%C3%B3mo-validar-una-curp-de-m%C3%A9xico
 */
class TinturasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:ADMIN', 'auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index(Request $request)
    {
        $response = $request->get("search");
        if(is_null($response)){
            return view("admin.tintura.index")
            ->with("workers", Tinturas::paginate())
            ->with("containsPaginate", true);
        }
        $request->validate(ToalleraController::RULES_SEARCH);
        return view("admin.tintura.index")
        ->with("workers", Tinturas::where("id", $response)->get())
        ->with("containsPaginate", false);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        if(Departament::isEmpty())
        {
            return view("admin.error")
            ->with("MessageOfEmptyTable", "No hay departamentos registrados, debe registrar al menos un departamento.");
        }
        return view("admin.tintura.create")
        ->with("departaments", Departament::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(ToalleraController::RULES);
        $response = $request->except(['_token']);
        
        try {
            Tinturas::create($response);
        } catch (\Illuminate\Database\QueryException $th) {
            return redirect()->route('tintura.create')->with("_INSERT", "_IS_NOT");
        }
        return redirect()->route('tintura.index')  
        ->with("INSERT", "IS_OK");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tinturas  $tinturas
     * @return \Illuminate\Http\Response
     */
    public function show(Tinturas $tinturas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tinturas  $tinturas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $worker = Tinturas::findOrfail($id);
       return view("admin.tintura.edit")
       ->with("departaments", Departament::get())
       ->with("worker", $worker);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tinturas  $tinturas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Tinturas::findOrfail($id);
        $request->validate(ToalleraController::RULES);
        $response = $request->except(['_token', "_method"]);
        Tinturas::where('id', '=', $id)->update($response);
        return redirect()->route('tintura.index')
        ->with("UPDATE", "IS_OK");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tinturas  $tinturas
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $worker = Tinturas::findOrfail($id);
        $worker->delete();
        return redirect()->route('tintura.index')->with("DELETE", "IS_OK");
        //
    }
      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $request->validate(CsvRules::RULES);
        try {
            $path = $request->file("cvs_file")->getRealPath();
            $departamentImport = new DBTinturas($path);
            $departamentImport->insert();
       } catch (\Exception $th) {
            return redirect()
            ->route('tintura.index')
            ->with("UPLOAD_ERROR", "IS_OK")
            ->with("message", $th->getMessage());
       }
       return redirect()
            ->route('tintura.index')
            ->with("UPLOAD_SUCCESS", "IS_OK");
      
        
    
    }

}
