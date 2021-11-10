<?php

namespace App\Http\Controllers\Admin\Rules;


class CsvRules
{
    const RULES = [
        "cvs_file" => 'required|file|mimes:csv,txt|max:512'
    ];
  
}
