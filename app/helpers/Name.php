<?php
namespace App\helpers;

class Name
{
    const NAME_PATTERN = '/^[\pL\s]+$/u';
    const ARTICLES = ["LA", "EL", "LO", "DEL", "DE"];
    const MIN_LEN_ART = 2;
    const MAX_LEN_ART = 3;
    const LAST_NAMES = 2;
    const MIN_WORDS_PER_FULLNAME = 3;
    public static function isValid($name)
    {
        return preg_match(Name::NAME_PATTERN, $name);
    }
    private static function isValidArtLen($word){
        $len = strlen($word);
        return $len == self::MIN_LEN_ART  || $len == self::MAX_LEN_ART;
    }
    private static function containsArticicles($words){
        foreach($words as $word){
            if(Name::isValidArtLen($word)){
                if(in_array(strtoupper($word), self::ARTICLES)){
                    return true;
                }
            }
        }

    }
    private static function getNameWithArticles($words){
        $countLastName = 0;
        $name = "";
        $lastName = "";
        foreach($words as $word){
            if(!in_array(strtoupper($word), self::ARTICLES)){
                $countLastName++;
            }
            if($countLastName > self::LAST_NAMES){
                $name.="{$word} ";
            }else{
                $lastName.="{$word} ";
            }
        }
        return array("LASTNAMES" => $lastName, "NAMES" => $name);
    }
    private static function getNameWhitoutArticles($fullName)
    {
        $lastNames = strtok($fullName, ' ') . ' ' . strtok(' ');
        if (str_word_count($fullName) == 4) {
            $names = strtok(' ') . ' ' . strtok(' ');
        } else {
            $names = strtok(' ');
        }
        return array("LASTNAMES" => utf8_decode(strtoupper($lastNames)), "NAMES" =>(strtoupper($names)));
    }
    public static function getNameForCredential($fullName){
        if(str_word_count($fullName) == self::MIN_WORDS_PER_FULLNAME){
            return Name::getNameWhitoutArticles($fullName);
        }
        $words = explode(' ', $fullName);
        return Name::containsArticicles($words) ?
            Name::getNameWithArticles($words) :
            Name::getNameWhitoutArticles($fullName);
    }

}