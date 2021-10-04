<?php
namespace App\helper;

class Nss
{
    const NSS_LENGTH = 11;
    public static function isValid($nss)
    {
        return strlen($nss) == Nss::NSS_LENGTH;
    }

}