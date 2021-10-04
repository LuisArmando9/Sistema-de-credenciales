<?php
namespace App\helpers\DbTables;
use Illuminate\Database\Eloquent\Model;
use App\Models\Toallera;
use Illuminate\Support\Facades\DB;
use App\helpers\DbTables\Constants\Constants;
use Exception;
class DBToallera extends DBEmployee{
    protected $array;
    public function __construct($path)
    {
        parent::__construct($path);
    }
    public function cleanTable(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Toallera::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
    public function insert($array = null)
    {
       parent::insert($array);
       if(Toallera::get()->count() == Constants::EMPTY){
           $this->cleanTable();
       }
       DB::beginTransaction();
       try {
           Toallera::insert($this->getDataToInsertIntoTable());
           DB::commit();
       } catch (\Exception $th) {
           DB::rollback();
           throw new Exception("Error al insertar los datos, verifiqué sus campos del csv.");
       }
    }
}