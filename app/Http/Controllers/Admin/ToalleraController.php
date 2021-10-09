<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Toallera;
use App\Models\Departament;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Rules\CsvRules;
use App\helpers\Csv\CSVEmployee;
use App\helpers\Csv\Constants\Tables;
use App\Http\Controllers\Admin\Rules\WorkerRules;
use Exception;

class ToalleraController extends Controller
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
            return view("admin.toallera.index")
            ->with("workers", Toallera::paginate())
            ->with("containsPaginate", true);
        }
        $request->validate(WorkerRules::getRulesWithId(Tables::TOALLERA));
        return view("admin.toallera.index")
        ->with("workers", Toallera::where("id", $response)->get())
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
        return view("admin.toallera.create")
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
        $request->validate(WorkerRules::TOALLERA);
        $response = $request->except(['_token']);
        
        try {
            Toallera::create($response);
        } catch (\Illuminate\Database\QueryException $th) {
            return redirect()->route('toallera.create')->with("_INSERT", "_IS_NOT");
        }
        return redirect()->route('toallera.index')  
        ->with("INSERT", "IS_OK");
    }

    /**
     * Display the specified resource.
     * @param  \App\Models\Tinturas  $tinturas
     * @return \Illuminate\Http\Response
     */
    public function show(Toallera $tinturas)
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
       $worker = Toallera::findOrfail($id);
       return view("admin.toallera.edit")
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
        Toallera::findOrfail($id);
        $tempId = $request->post("id");
        if($tempId == $id){
            $request->validate(WorkerRules::RULES);
        }else{
            $request->validate(WorkerRules::getRulesWithId(Tables::TOALLERA));
        }
        $response = $request->except(['_token', "_method"]);
        Toallera::where('id', '=', $id)->update($response);
        return redirect()->route('toallera.index')
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
        $worker = Toallera::findOrfail($id);
        $worker->delete();
        return redirect()->route('toallera.index')->with("DELETE", "IS_OK");
        //
    }
    /**
     * Upload the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $request->validate(CsvRules::RULES);
        $path = $request->file("cvs_file")->getRealPath();
        try {
            $path = $request->file("cvs_file")->getRealPath();
            $departamentImport = new CSVEmployee($path, Tables::TOALLERA);
            $departamentImport->insert();
       } catch (\Exception $th) {
            return redirect()
            ->route('toallera.index')
            ->with("UPLOAD_ERROR", "IS_OK")
            ->with("message", $th->getMessage());
       }
       return redirect()
            ->route('toallera.index')
            ->with("UPLOAD_SUCCESS", "IS_OK");

    }
}
