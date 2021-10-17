<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\helpers\Csv\Constants\Table;
class ResetTablesController extends Controller
{

    private function resetTable($table){
        try{
           Table::clean($table);
        }catch(\Exception $e){
            return back()
            ->with("toast_error", "<small>No se puede resetear la tabla: <b>{$table}</b>, contiene dependecias.</small>");
        }
        return back()
        ->with("toast_success", "<small>Se reseteo  la tabla: <b>{$table}</b>, correctamente.</small>");

    }
  
    public function resetTintura(){
        return $this->resetTable(Table::TINTURA);
    }
    public function resetToallera(){
        return $this->resetTable(Table::TOALLERA);

    }
    public function resetDepartament(){
        return $this->resetTable(Table::DEPARTAMENT);
    }
    public function resetDenomination(){
        return $this->resetTable(Table::DENOMINATION);
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
