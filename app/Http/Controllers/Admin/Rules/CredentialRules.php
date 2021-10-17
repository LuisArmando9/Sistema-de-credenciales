<?php
namespace App\Http\Controllers\Admin\Rules;
class CredentialRules{
    const RULES = [
        "id" =>["required", "numeric", "not_in:0", "gt:0"],
        "denomination" =>["required","string","regex:/TOALLERA|TINTURA/"]
    ];
}