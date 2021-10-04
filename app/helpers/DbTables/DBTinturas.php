<?php
namespace App\helpers\DbTables;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tinturas;
use Illuminate\Support\Facades\DB;
use App\helpers\DbTables\Constants\Constants;
use Exception;
class DBTinturas extends DBEmployee{
    protected $array;
    public function __construct($path)
    {
        parent::__construct($path);
    }
    public function cleanTable(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Tinturas::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
    public function insert($array = null)
    {
       parent::insert($array);
       if(Tinturas::get()->count() == Constants::EMPTY){
           $this->cleanTable();
       }
       DB::beginTransaction();
       try {
           Tinturas::insert($this->getDataToInsertIntoTable());
           DB::commit();
       } catch (\Exception $th) {
           DB::rollback();
           throw new Exception("Error al insertar, verifiqué sus campos del csv.");
       }    
    }
}