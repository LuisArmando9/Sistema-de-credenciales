<?php
namespace App\Http\Controllers\Admin\Rules;
class PdfRules{
    const RULES_PER_ONE_WORKER = [
        /*"minRange" =>["required", "numeric", "lte:maxRange", "not_in:0", "gt:0"],
        "maxRange" =>[ "required", "numeric", "gte:minRange", "not_in:0", "gt:0"],*/
        "denomination" =>["required","string","regex:/TOALLERA|TINTURA/"],
        "name"=>"required"
    ];
    const RULES_FOR_ALL_WORKERS = [
        "denomination" =>["required","string","regex:/TOALLERA|TINTURA/"],
    ];
    const RULES_PER_RANGES = [
        "minRange" =>["required", "numeric", "lte:maxRange", "not_in:0", "gt:0"],
        "maxRange" =>[ "required", "numeric", "gte:minRange", "not_in:0", "gt:0"],
        "denomination" =>["required","string","regex:/TOALLERA|TINTURA/"],
      
    ];
}