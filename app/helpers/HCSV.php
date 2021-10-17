<?php
namespace App\helpers;

use Exception;

class HCSV
{
    const EMPTY_ARRAY = 0;
    private $path;
    private $array;
    public function __construct($path)
    {
        $this->path = $path;
        $this->array =  array();
    }
    public function toArray()
    { 
        $this->array = array_map("utf8_encode",file($this->path));
        $csvLines = array();
        foreach($this->array as $csvline)
        {
            array_push($csvLines, explode(',', $csvline));
        }
        return $csvLines;
        
    }
}