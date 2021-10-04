<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tinturas extends Model
{
    use HasFactory;
    protected $table = 'tintura';
    public $timestamps = true;
    protected $fillable = [
        'worker',
        'curp',
        'nss',
        'departamentId',
        'entry',
        'active'
    ];
}
