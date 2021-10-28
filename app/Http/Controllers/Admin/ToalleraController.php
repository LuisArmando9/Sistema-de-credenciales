<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Toallera;
use App\Models\Departament;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Rules\CsvRules;
use App\helpers\Csv\CSVWorker;
use App\helpers\Csv\Constants\Table;
use App\helpers\Name;
use App\Http\Controllers\Admin\Rules\WorkerRules;
use Exception;
class ToalleraController extends Controller
{

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
        if(is_numeric($response)){   
            $workers = Toallera::where("id", $response)->get();//$query->where($column, 'like', '%'.$value.'%');
        }elseif(Name::isValid($response)){
            $workers = Toallera::where("worker",'like', '%'.$response.'%' )->get();
        }else{
            return back();
        }
        return view("admin.toallera.index")
        ->with("workers",$workers)
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
        $request->validate(WorkerRules::getRulesWithId(Table::TOALLERA));
        $response = $request->except(['_token']);
        
        try {
            Toallera::create($response);
        } catch (\Illuminate\Database\QueryException $th) {
            return redirect()->route('toallera.create')
            ->with("toast_error", "No se puedo crear  el registro.");
        }
        return redirect()->route('toallera.index')  
        ->with("toast_success", "Se ha creado un nuevo empleado.");
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
        if($request->post("id") ==  $id){
            $request->validate(WorkerRules::RULES);
        }else{
            $request->validate(WorkerRules::getRulesWithId(Table::TOALLERA));
        }
        $response = $request->except(['_token', "_method"]);
        Toallera::where('id', '=', $id)->update($response);
        return redirect()->route('toallera.index')
        ->with("toast_succes", "Se actualizo los datos del empleado {$response['worker']}");
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
        return redirect()->route('toallera.index')
        ->with("toast_success", "Se ha eliminado el empleado{$worker->worker}");
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
            $departamentImport = new CSVWorker($path, Table::TOALLERA);
            $departamentImport->insert();
       } catch (\Exception $th) {
            return redirect()
            ->route('toallera.index')
            ->with("toast_error", $th->getMessage());
       }
       return redirect()
            ->route('toallera.index')
            ->with("toast_success", "Se han insertado los datos del csv");

    }
}
