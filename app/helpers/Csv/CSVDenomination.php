<?php
namespace App\helpers\Csv;

use App\helpers\Csv\CSV;
use App\helpers\Csv\Constants\Tables;
use Exception;

class CSVDenomination extends CSV{

    protected $tableName = Tables::DENONINATION;
    public function __construct($path)
    {
        parent::__construct($path);
    }

}