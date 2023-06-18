<?php

function stkPush(array $stkValues) : string
{
    $curlPostData = [
        'Amount'            => $stkValues['amount'],
        'Password'          => $stkValues['password'],
        'Timestamp'         => $stkValues['timestamp'],
        'CallBackURL'       => $_ENV['CALLBACK_URL'],
        'TransactionDesc'   => $stkValues['description'],
        'PhoneNumber'       => $stkValues['phoneNumber'],
        'PartyA'            => $stkValues['phoneNumber'],
        'TransactionType'   => 'CustomerPayBillOnline',
        'AccountReference'  => $stkValues['accountReference'],
        'PartyB'            => $stkValues['businessShortCode'],
        'BusinessShortCode' => $stkValues['businessShortCode']
    ];

    $dataString = json_encode($curlPostData);

    $curlHeader = array('Content-Type:application/json', 'Authorization:Bearer ' . $stkValues['accessToken']);

    $curlResponse = curl($_ENV['SAFARICOM_ENDPOINT_URL'], $curlHeader, 'stk_push', $dataString);

    $decodedCurlResponse = json_decode($curlResponse, true);
    
    $CheckoutRequestID = $decodedCurlResponse['ResponseCode'] == "0" ? $decodedCurlResponse['CheckoutRequestID'] : "";
    
    return $CheckoutRequestID;
}