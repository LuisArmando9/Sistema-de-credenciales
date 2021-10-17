<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class ResetTablesController extends Controller
{

    private function resetTable($table){
        try{
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table($table)->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }catch(\Exception $e){
            return back()
            ->with("toast_error", "<small>No se puede resetear la tabla: <b>{$table}</b>, contiene dependecias.</small>");
        }
        return back()
        ->with("toast_success", "<small>Se reseteo  la tabla: <b>{$table}</b>, correctamente.</small>");

    }
  
    public function resetTintura(){
        return $this->resetTable("tintura");
    }
    public function resetToallera(){
        return $this->resetTable("toallera");

    }
    public function resetDepartament(){
        return $this->resetTable("departament");
    }
    public function resetDenomination(){
        return $this->resetTable("denomination");

    }
    public function resetAll(){
        $this->resetTintura();
        $this->resetToallera();
        $this->resetDepartament();
        $this->resetDenomination();
        return back()
        ->with("toast_success", "<small>Se han reseteado todas las tablas </small>");
    }
}
