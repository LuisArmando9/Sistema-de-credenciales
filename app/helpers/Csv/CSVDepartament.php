<?php
namespace App\helpers\Csv;

use App\helpers\Csv\CSV;
use App\helpers\Csv\Constants\Table;
use App\helpers\Csv\Constants\Constants;
use App\Models\Denomination;
use Exception;

class CSVDepartament extends CSV{

    protected $tableName = Table::DEPARTAMENT;
    protected $denominationMask;
    private function isValidDenominationId($id){
        $offset = 1 << $id;
        return ($offset &  $this->denominationMask) == $offset;

    }
    private function validateCsv(){
        foreach($this->array as $data){
            $id = $data[Constants::DENOMINATION_ID];
            if(!$this->isValidDenominationId($id)){
                throw new Exception("El ID {$data[Constants::DENOMINATION_ID]} de la razón social es desconocido");
            }
        }
       

    }
    public function __construct($path)
    {
        parent::__construct($path);
        if(Table::isEmpty(Table::DENOMINATION)){
            throw new Exception("No hay ninguna razon social registrada.");
        }
        foreach(Denomination::get()->pluck("id") as $id){
            $this->denominationMask |= 1<<$id;
        }
        $this->validateCsv();   
    }

}