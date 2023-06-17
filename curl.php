<?php

function curl(string $url, array $curl_header, string $methodFor, string $data_string = null) : mixed
{
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $curl_header);

    switch($methodFor) {
        case 'token' :
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            break;
        case 'stk_push' :
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            break;
        case 'stk_status_token' :
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_USERPWD, $data_string); //key and secret
            break;
        case 'stk_status_response' :
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            break;
    }
    
    $curl_response = curl_exec($curl);
    curl_close($curl);

    return $curl_response;
}