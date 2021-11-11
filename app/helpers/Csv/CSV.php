<?php
namespace App\helpers\Csv;


use App\helpers\Csv\Constants\Constants;
use App\helpers\Csv\Constants\Table;
use Illuminate\Support\Facades\DB;
use App\helpers\HCSV;
use Exception;
class CSV implements ICSV {
    protected $tableName;
    protected $array;
   
    public function getFieldsOfTable(){

        if(Table::isWorkerTable($this->tableName)){
            $fieldOfTable =  function($data){
                return array(
                    "worker" => $data[Constants::WORKER_NAME],
                    "curp" => $data[Constants::WORKER_CURP],
                    "nss" => $data[Constants::WORKER_NSS],
                    "id" => $data[Constants::WORKER_ID],
                    "entry" =>Constants::getCorrectDate( $data[Constants::WORKER_ENTRY]),
                    "departamentId" => $data[Constants::DEPARTAMENT_ID],
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                    "active" => 1
                );
            };
        }
        else{
            $fieldOfTable = match($this->tableName){
                Table::DEPARTAMENT => function($data){
                    return array(
                        "id" => $data[Constants::DEPARTAMENT_ID_FOR_TABLE],
                        "departamentName" => $data[Constants::DEPARTAMENT_NAME],
                        "denominationId" => $data[Constants::DENOMINATION_ID],
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                        );
                },
                Table::DENOMINATION => function($data){
                    return array(
                        "id" => $data[Constants::DEPARTAMENT_ID_FOR_TABLE],
                        "denominationName" => $data[Constants::DEPARTAMENT_NAME],
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                        );

                },
                default => throw new \Exception('Unsupported'),
            };
        }
        return $fieldOfTable;

    }
    public function getTableData(){
        $fieldsOfTable = $this->getFieldsOfTable();
        $newData = array();
        foreach($this->array as $data){
            array_push($newData, $fieldsOfTable($data));
        }
        return $newData;
    }
    public  function insert($array=null){
        if(!is_null($array)){
            $this->array = $array;
        }
        if(Table::isEmpty($this->tableName)){
            Table::clean($this->tableName);
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
    public function __construct($path)
    {
        $csv = new HCSV($path);
        $this->array = $csv->toArray();
        if(Constants::isEmpty($this->array)){
            throw new Exception("El archivo csv esta vacio");
        }

    }
}