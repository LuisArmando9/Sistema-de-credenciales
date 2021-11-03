<?php
namespace App\helpers;

class HDate{
    const MONTHS=  ["january"=> "Enero",
    "february"=> "Febrero",
    "march"=> "Marzo",
    "april"=> "Abril",
    "may"=> "Mayo",
    "june"=> "Junio",
    "july"=> "Julio",
    "jugust"=> "Agosto",
    "september"=> "Septiembre",
    "october"=> "Octubre",
    "november"=> "Noviembre",
    "december"=> "Diciembre"];
    public static function isValid($string)
    {
        return strtotime($string) ? true : false;

    }
    public static function parse($date)
    {
        $time = strtotime($date);
        $month = self::MONTHS[strtolower(strftime("%B",  $time))];
        $day = strftime("%d", $time);
        $year = strftime("%Y", $time);
        $month = strtoupper($month);
        return "{$day} DE {$month} {$year}";

    }
}