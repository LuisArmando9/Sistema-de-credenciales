<?php
namespace App\helpers\Csv\Constants;
use Illuminate\Support\Facades\DB;

class Table{
    const TINTURA = "TINTURA";
    const  TOALLERA = "TOALLERA";
    const DENOMINATION = "DENOMINATION";
    const DEPARTAMENT = "DEPARTAMENT";
    public static function isEmpty($tablename){
        return DB::table($tablename)->get()->count() == Constants::EMPTY;
    }
    public static function isWorkerTable($tablename){
        return $tablename == Table::TINTURA || $tablename == Table::TOALLERA;
    }
}