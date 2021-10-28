<?php
namespace App\Http\Controllers\Admin\Rules;
class CredentialRules{
    const RULES = [
        "credential-search" =>["required", "min:1", "max:255"],
        "denomination" =>["required","string","regex:/TOALLERA|TINTURA/"]
    ];
}