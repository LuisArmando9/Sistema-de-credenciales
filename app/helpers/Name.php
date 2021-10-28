<?php
namespace App\helpers;

class Name
{
    const NAME_PATTERN = '/^[\pL\s]+$/u';
    const MIN_WORDS_PER_NAME = 3;
    public static function isValid($name)
    {
        if(preg_match(Name::NAME_PATTERN, $name)){
            return str_word_count($name) == self::MIN_WORDS_PER_NAME;
        }
        return false;
    }

}