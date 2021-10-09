<?php
namespace App\helpers\Csv;
interface ICSV{
    public function cleanTable();
    public function insert($array=null);
    public function getFieldsOfTable();
    public function getTableData();
}