<?php
namespace App\helpers;

class HDate{
    const MONTHS =["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Octubre",
        "Noviembre", "Diciembre"];
    public static function isValid($string)
    {
        return strtotime($string) ? true : false;

    }
    public static function parse($date)
    {
        setlocale(LC_ALL, 'es_ES');
        $parseDate = strtoupper(date("j DE F, Y", strtotime($date)));
        return $parseDate;

    }
}