<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denomination extends Model
{
    use HasFactory;
    const EMPTY_TABLE = 0;
    protected $table = 'denomination';
    public $timestamps = true;
    protected $fillable = [
        'denominationName'
    ];
    public static function isEmpty(): bool
    {
        return Denomination::get()->count() == self::EMPTY_TABLE;
    }
    
   

}
