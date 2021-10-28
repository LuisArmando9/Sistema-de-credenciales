<?php
namespace App\Http\Controllers\Admin\Rules;
class WorkerRules{
    const RULES = [  
        "worker" => "required|alpha_spaces",
        "curp" => [
            "required",
            "string",
            "min:18",
            "max:18",
            "regex:/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/",
        ],
        "nss" => "required|numeric|digits:11",
        "departamentId"  => "required|numeric",
        "entry" => "required|date",
        "active" =>"required|boolean"
    ];
    const SEARCH =[
        "search" =>
        [
            "required",
            
        ]
    ];
    public static function getRulesWithId($tablename){
        $newRules = WorkerRules::RULES;
        $newRules["id"] = "required|numeric|unique:{$tablename}";
        return $newRules;
    }
}