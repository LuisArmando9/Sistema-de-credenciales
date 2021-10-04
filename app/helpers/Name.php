<?php
namespace App\helpers;

class Name
{
    const NAME_PATTERN = '/^[\pL\s]+$/u';
    public static function isValid($name)
    {
        return preg_match(Name::NAME_PATTERN, $name);
    }

}