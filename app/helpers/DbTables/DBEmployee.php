<?php
namespace App\helpers\DbTables;

use App\helper\Nss;
use App\helpers;
use App\helpers\_Date;
use App\helpers\Curp;
use App\helpers\Cvs;
use App\helpers\Name;
use App\Models\Departament;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\helpers\DbTables\Constants\Constants;

class DBEmployee
{
  
    protected $array;
    protected $departamentMask;
    public function __construct($path)
    {
     
        $csv = new Cvs($path);
        $this->array = $csv->toArray();
        $departaments = Departament::get()->pluck("id");
        if(count($this->array) == Constants::EMPTY){
            throw new Exception("El csv proporcionado esta vacio.");
        }
        if($departaments->count() == Constants::EMPTY){
            throw new Exception("No contiene departamentos agregados");
        }
        foreach($departaments as $id){
            $this->departamentMask |= 1 << $id;
        }
    }
    public function getDataToInsertIntoTable(){
        $newData = array();
        foreach ($this->array as $data) {
            array_push($newData, $this->getFieldsOfTable($data));
        }
        return $newData;
    }
    protected function getFieldsOfTable($array)
    {
        
        return array(
            "worker" => $array[Constants::WORKER_NAME],
            "curp" => $array[Constants::WORKER_CURP],
            "nss" => $array[Constants::WORKER_NSS],
            "id" => $array[Constants::WORKER_ID],
            "entry" => $array[Constants::WORKER_ENTRY],
            "departamentId" => $array[Constants::DEPARTAMENT_ID],
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
            "active" => 1
        );
    }
    private function isValidDepartamentId($id){
        $offset = 1 << $id;
        return ($offset &  $this->departamentMask) == $offset;

    }
    private function validateCsv(){
        foreach($this->array as $data){
            $id = $data[Constants::DEPARTAMENT_ID];
            if(!$this->isValidDepartamentId($id)){
                throw new Exception("El departamento con ID {$data[Constants::DEPARTAMENT_ID]} es desconocido.");
            } 
            if(count($data) != Constants::MAX_DATA_TO_ARRAY_WORKER){
                throw new Exception("El empleado {$data[Constants::WORKER_NAME]}, no contiene todos los datos para insertar.");
            }
        }

    }
   
    public function insert($array = null)
    {
        if(!is_null($array)){
            $this->array = $array;
        }
        $this->validateCsv();
       
    }

}