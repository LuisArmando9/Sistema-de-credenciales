<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Rules\CsvRules;
use App\Http\Controllers\Controller;
use App\Models\Denomination;
use Illuminate\Http\Request;
use App\helpers\Csv\CSVDenomination;


class DenominationController extends Controller
{
    const RULES = [
        "denominationName" => 'required|string|min:2|max:255'
    ];
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
        $denominationName = $request["denominationName"];
        return redirect()->route('denomination.index')
        ->with("toast_succes","Se ha insertado la razón social:{$denominationName}");
        
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
        ->with("toast_success","Se actualizo correctamente {$response['denominationName']}");

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
                return redirect()->route('denomination.index')
                ->with("toast_error", "Error al intentar eliminar{$denomination->denominationName}");
        }
       return redirect()->route('denomination.index')
        ->with("toast_success", "Se elimino correctamente {{$denomination->denominationName}");

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
            $denominationImport = new CSVDenomination($path);
            $denominationImport->insert();
        }catch(\Exception $th){
            
            return redirect()->route('denomination.index')
            ->with("toast_error", $th->getMessage());
        }
        return redirect()->route('denomination.index')
            ->with("toast_success", "Se han insertado los datos del csv.");
    }
}
