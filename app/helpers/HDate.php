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
        $dateTime = date_create_from_format("Y-m-d", $date);
        $month = (int)$dateTime->format("n") -1;
        $monthName = HDate::MONTHS[$month];
        return "{$dateTime->format('d')} de {$monthName} {$dateTime->format('Y')}";

    }
}