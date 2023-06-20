<?php

function sanitizeSTKData(mixed $data, array $rule = array()) : bool
{
    if(is_null($data) || empty($data)) return false;

    foreach($rule as $ruleItem){
        switch ($ruleItem) {
            case 'string' :
                if(!is_string($data)) return false;
                break;
            case 'numeric' :
                if(!is_numeric($data)) return false;
                break;
            default :
                return false;
        }
    }

    return  true;
}