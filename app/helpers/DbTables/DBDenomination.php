<?php
namespace App\helpers\DbTables;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tinturas;
use Illuminate\Support\Facades\DB;
use App\Models\Denomination;
use App\helpers\Cvs;
use App\helpers\DbTables\Constants\Constants;
use Exception;

class DBDenomination{

    private $denominationMask;
    private $path;
    private $array;


    public function __construct($path)
    {
        $this->path = $path;
        $cvs = new Cvs($this->path);
        $this->array = $cvs->toArray();
        if(Constants::isEmpty($this->array)){
            throw new Exception("The csv is empty");
        }
      
        
        
    }
    private function cleanTable(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Denomination::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
    private function getFieldsOfTable($array){
        return array(
            "id" => $array[Constants::DEPARTAMENT_ID_FOR_TABLE],
            "denominationName" => $array[Constants::DEPARTAMENT_NAME],
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
            );
    }
    private function getDataToInsertIntoTable(){
        $newData = array();
        foreach ($this->array as $data) {
            array_push($newData, $this->getFieldsOfTable($data));
        }
        return $newData;
    }
    public function insert($array=null){
        if( Denomination::get()->count() == Constants::EMPTY){
           $this->cleanTable();
        } 
        if(!is_null($array)){
            $this->array = $array;
        }
        DB::beginTransaction();
        try {
            Denomination::insert($this->getDataToInsertIntoTable());
            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();
            throw new Exception("Error al insertar, verifiqué sus campos del csv.");
        }    
    }

}