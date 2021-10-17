<?php
namespace App\helpers\Csv\Constants;
use Illuminate\Support\Facades\DB;
class Table{
    const TINTURA = "tintura";
    const  TOALLERA = "toallera";
    const DENOMINATION = "denomination";
    const DEPARTAMENT = "departament";
    public static function isEmpty($tablename){
        return DB::table($tablename)->get()->count() == Constants::EMPTY;
    }
    public static function isWorkerTable($tablename){
        return $tablename == Table::TINTURA || $tablename == Table::TOALLERA;
    }
    public static function clean($table){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table($table)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}