<?php

function curl(string $url, array $curlHeader, string $methodFor, string $dataString = null) : mixed
{
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $curlHeader);

    switch($methodFor) {
        case 'token' :
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            break;
        case 'stk_push' :
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);
            break;
        case 'stk_status_response' :
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);
            break;
    }
    
    $curlResponse = curl_exec($curl);
    curl_close($curl);

    return $curlResponse;
}