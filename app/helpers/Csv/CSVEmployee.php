<?php
namespace App\helpers\Csv;


use Exception;
use App\Models\Departament;
use App\helpers\Csv\Constants\Constants;

class CSVEmployee extends CSV 
{

    protected $tableName;  
    private $departamentMask;
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
    public function __construct($path, $tablename)
    {
        $this->tableName = $tablename;
        parent::__construct($path);
        $departaments = Departament::get()->pluck("id");
        if($departaments->count() == Constants::EMPTY){
            throw new Exception("No contiene departamentos agregados");
        }
        foreach($departaments as $id){
            $this->departamentMask |= 1 << $id;
        }
        $this->validateCsv();
    }
}