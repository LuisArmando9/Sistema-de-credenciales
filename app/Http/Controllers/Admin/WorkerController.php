<?php

namespace App\Http\Controllers\Admin;

use App\helpers\Csv\Constants\Table;
use App\helpers\Name;
use App\Http\Controllers\Admin\Rules\PdfRules;
use App\Http\Controllers\Admin\Rules\WorkerRules;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $denomination = $request->get("denomination");
        if(is_null($denomination)){
            return [];
        }
        if(!Table::isWorkerTable($denomination)){
            return [];
        }
        $denomination = strtolower($denomination);
        return DB::table($denomination)->paginate();
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
    public function show(Request $request, $search)
    {
     
        $denomination = strtolower($request->get("denomination"));
        if(!Table::isWorkerTable($denomination)){
            return abort(404);
        }
        if(empty($search)){
            return abort(400);
        }
        if(is_numeric($search)){
            return DB::table($denomination)->where("id", $search)->get();
        }elseif(Name::isValid($search)){
            return DB::table($denomination)->where("worker",'like', '%'.$search.'%' )->get();
        }else{
            return abort(404);
        }
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
