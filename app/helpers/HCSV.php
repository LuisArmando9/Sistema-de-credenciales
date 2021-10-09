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
        $this->array = array_map('str_getcsv',
            file($this->path));
        return $this->array;
        
    }
}