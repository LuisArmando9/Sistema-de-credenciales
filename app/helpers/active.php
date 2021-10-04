<?php
const CLASSNAME = "active";
function active($path)
{
    if(request()->is($path)){
        return CLASSNAME;
    }else{
        if(str_contains(request()->url(), $path)){
            return CLASSNAME;
        }
        return "";
    }
}
