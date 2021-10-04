<?php
namespace App\helpers;

class _Date{
    public static function isValid($string)
    {
        return strtotime($string) ? true : false;

    }
}