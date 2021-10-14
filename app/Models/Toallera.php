<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toallera extends Model
{
    use HasFactory;
    protected $table = 'toallera';
    public $timestamps = true;
    protected $fillable = [
        'worker',
        'curp',
        'nss',
        'departamentId',
        'entry',
        'active',
        'id'
    ];
}
