<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Constraint\IsEmpty;

class Departament extends Model
{
    use HasFactory;
    const EMPTY_TABLE = 0;
    protected $table = 'departament';
    public $timestamps = true;
    protected $fillable = [
        'denominationId',
        'departamentName',
        'id'
    ];
    public static  function isEmpty()
    {
        
        return Departament::get()->count() == self::EMPTY_TABLE;
    }
}
