<?php
namespace App\helpers\CSV;

use App\helpers\Csv\Constants\Tables;
use App\helpers\Csv\CSV;
use App\Models\Denomination;
use App\helpers\Csv\Constants\Constants;
use Exception;
class CSVDepartament extends CSV{

    protected $tableName = Tables::DEPARTAMENT;
    private $denominationMask;
    private function isValidDenominationId($id)
    {
        $offset = 1 << $id;
        return ( $offset  & $this->denominationMask) ==  $offset;
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
        $denominations = Denomination::get()->pluck("id");
        if($denominations->count() == Constants::EMPTY){
           throw new Exception("No contiene ningun registro asociado a la tabla de razon social"); 
        }
        foreach($denominations as $id){
            $this->denominationMask |= 1<<$id;
        }
        $this->validateCsv();
    }
}