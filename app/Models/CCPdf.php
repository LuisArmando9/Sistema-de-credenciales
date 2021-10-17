<?php

namespace App\Models;

use App\helpers\Csv\Constants\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CCPdf extends Model
{
    use HasFactory;
    protected $table = 'pdf';
    public $timestamps = true;
    protected $fillable = [
        'minRange',
        'maxRange',
        'credentialsNumber',
        "pdfName",
        "denomination"
    ];
    public static function getTotal()
    {
       
        return CCPdf::sum("credentialsNumber");
    }
}
