<?php
namespace App\helpers\Csv;

use App\helpers\Csv\CSV;
use App\helpers\Csv\Constants\Table;
use Exception;

//testin lol lol
class CSVDenomination extends CSV{

    protected $tableName = Table::DENOMINATION;
    public function __construct($path)
    {
        parent::__construct($path);
    }

}
