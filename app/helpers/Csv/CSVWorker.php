<?php
namespace App\helpers\Csv;

use App\helpers\Csv\CSV;
use App\helpers\Csv\Constants\Table;
use App\helpers\Csv\Constants\Constants;
use App\Models\Departament;
use Exception;

class CSVWorker extends CSV{

    protected $tableName;
    protected $departamentMask;
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
        if(Table::isEmpty(Table::DEPARTAMENT)){
            throw new Exception("No hay ningun departamento registrado");
        }
        foreach(Departament::get()->pluck("id") as $id){
            $this->departamentMask |= 1 << $id;
        }
        $this->validateCsv();
        
    }

}