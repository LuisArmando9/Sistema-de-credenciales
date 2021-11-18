<?php
namespace App\Http\Controllers\Admin\Rules;
class DepartamentRules{
    const RULES = [
        "departamentName" => 'required|alpha_spaces',
        "denominationId" => 'required|numeric'
    ];
    public static function getRulesWithId(){
        $newRules = DepartamentRules::RULES;
        $newRules["id"] =  "required|numeric|unique:departament";
        return $newRules;
    }
}