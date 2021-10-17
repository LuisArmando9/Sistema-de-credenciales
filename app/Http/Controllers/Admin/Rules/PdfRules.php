<?php
namespace App\Http\Controllers\Admin\Rules;
class PdfRules{
    const RULES = [
        "minRange" =>["required", "numeric", "lte:maxRange", "not_in:0", "gt:0"],
        "maxRange" =>[ "required", "numeric", "gte:minRange", "not_in:0", "gt:0"],
        "denomination" =>["required","string","regex:/TOALLERA|TINTURA/"]
    ];
}