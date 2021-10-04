<?php
namespace App\helpers\DbTables;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tinturas;
use App\Models\Denomination;
use App\helpers\Cvs;
use App\helpers\DbTables\Constants\Constants;
use App\Models\Departament;
use Exception;
use Illuminate\Support\Facades\DB;
class DBDepartament{

    private $denominationMask;
    private $path;
    private $array;

    public function __construct($path)
    {
        $this->path = $path;
        $csv = new Cvs($this->path);
        $denominations = Denomination::get()->pluck("id");
        $this->array = $csv->toArray();
        if(Constants::isEmpty($denominations) || 
        Constants::isEmpty($this->array)){
            throw new Exception("The tables are empties");
        }
        foreach($denominations as $id){
            $this->denominationMask |= 1<<$id;
        }
    }
    private function getFieldsOfTable($array){
        return array(
            "id" => $array[Constants::DEPARTAMENT_ID_FOR_TABLE],
            "departamentName" => $array[Constants::DEPARTAMENT_NAME],
            "denominationId" => $array[Constants::DENOMINATION_ID],
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
            );
    }
    private function isValidDenominationId($id)
    {
        $offset = 1 << $id;
        return ( $offset  & $this->denominationMask) ==  $offset;
    }
    private function cleanTable(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Departament::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
    private function getDataToInsertIntoTable(){
        $newData = array();
        foreach ($this->array as $data) {
            array_push($newData, $this->getFieldsOfTable($data));
        }
        return $newData;
    }
    private function validateDenominationIds(){
        foreach($this->array as $data){
            $id = $data[Constants::DENOMINATION_ID];
            if(!$this->isValidDenominationId($id)){
                throw new Exception("El ID {$data[Constants::DENOMINATION_ID]} de la razón social es desconocido");
            }
        }

    }
    public function insert($array=null){
        if(!is_null($array)){
            $this->array = $array;
        }
        if(Departament::get()->count() == Constants::EMPTY){
           $this->cleanTable();
        }        
        $this->validateDenominationIds();
        DB::beginTransaction();
        try {
            Departament::insert($this->getDataToInsertIntoTable());
            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();
            throw new Exception("Error al insertar, verifiqué sus campos del csv.");
        } 
    }

}