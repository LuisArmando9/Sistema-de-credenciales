<?php
namespace App\helpers\Csv;
use Illuminate\Support\Facades\DB;
use App\helpers\Csv\Constants\Tables;
use App\helpers\Csv\Constants\Constants;
use Exception;
use App\helpers\HCSV;

class CSV implements ICSV{
    protected $tableName;
    protected $array;
    public function __construct($path)
    {
        $csv = new HCSV($path);
        $this->array = $csv->toArray();
        $registerNumber = DB::table($this->tableName)->get()->count();
        if(Constants::isEmpty($this->array)){
            throw new Exception("El csv esta vacio");
        }

    }
    private function isTableWorker(){
        return $this->tableName == Tables::TINTURA 
            || $this->tableName == Tables::TOALLERA;

    }
    public function cleanTable(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table($this->tableName)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
    public function isEmpyTable($tablename=null){
        $tempTableName = $this->tableName;
        if(!is_null($tablename)){
            $tempTableName = $tablename;
        }
        return DB::table($tempTableName)
        ->get()->count() 
        == Constants::EMPTY;
        
    }
    public function getFieldsOfTable(){
        if($this->isTableWorker()){
            $fieldsOfTable = function($data){
                return array(
                    "worker" => $data[Constants::WORKER_NAME],
                    "curp" => $data[Constants::WORKER_CURP],
                    "nss" => $data[Constants::WORKER_NSS],
                    "id" => $data[Constants::WORKER_ID],
                    "entry" => $data[Constants::WORKER_ENTRY],
                    "departamentId" => $data[Constants::DEPARTAMENT_ID],
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                    "active" => 1
                );
            };
        }else{
            $fieldsOfTable = match($this->tableName){
                Tables::DEPARTAMENT => function($data){
                    return array(
                        "id" => $data[Constants::DEPARTAMENT_ID_FOR_TABLE],
                        "departamentName" => $data[Constants::DEPARTAMENT_NAME],
                        "denominationId" => $data[Constants::DENOMINATION_ID],
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                        );
                },
                Tables::DENONINATION => function($data){
                    return array(
                        "id" => $data[Constants::DEPARTAMENT_ID_FOR_TABLE],
                        "denominationName" => $data[Constants::DEPARTAMENT_NAME],
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                        );

                },
                default => throw new Exception("Nombre de la tabla es invalido ")
            };
            
        }
        return $fieldsOfTable;

    }
    public function getTableData(){
        $newData = array();
        $fieldOfTable = $this->getFieldsOfTable();
        foreach ($this->array as $data) {
            array_push($newData,  $fieldOfTable($data));
        }
        return $newData;
        
    }

    public function insert($array=null){
        if(!is_null($array)){
            $this->array = $array;
        }
        if($this->isEmpyTable()){
            $this->cleanTable();
        }
        DB::beginTransaction();
        try {
            DB::table($this->tableName)->insert($this->getTableData());
            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();
            throw new Exception("Error al insertar, verifiqué sus campos del csv.");
        } 

    }
}