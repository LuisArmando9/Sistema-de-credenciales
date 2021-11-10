<?php
namespace App\helpers\Csv\Constants;
use DateTime;
class Constants {
    const EMPTY = 0;
    /***
    * csv positions for tinturas and toallera(workers)
    */
    const WORKER_ID = 0;
    const WORKER_NAME = 1;
    const WORKER_CURP = 2;
    const DEPARTAMENT_ID = 3;
    const WORKER_NSS = 4;
    const WORKER_ENTRY = 5;
    const  MAX_DATA_TO_ARRAY_WORKER = 6;
    /***
    * END
    */
    /***
    * csv positions for departament
    */
    const DEPARTAMENT_NAME = 1;
    const DENOMINATION_ID = 2;
    const DEPARTAMENT_ID_FOR_TABLE = 0;
 
    /***
    * END
    */
   
    /***
    * csv positions for razon social(denomination)
    */
    const DENOMINATION_ID_FOR_TABLE = 0;
    const DENOMINATION_NAME = 1; 
    /***
    * END
    */
    const MIN_RESULT = 1;
    public static function isEmpty($data){
        return count($data) == self::EMPTY;
    }
    public static function getCorrectDate($date){
        $newData =  new DateTime(str_replace("/", "-", $date));  //15/03/2015
        return $newData->format('Y-m-d');;
    }
    
   
}