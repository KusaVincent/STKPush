<?php

function stkPush(array $stkValues) : mixed
{
    $access_token = newAccessToken($stkValues['consumerKey'], $stkValues['consumerSecret']);

    $curl_post_data = [
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

    $data_string = json_encode($curl_post_data);

    $curl_header = array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token);

    $curl_response = curl($_ENV['SAFARICOM_ENDPOINT_URL'], $curl_header, 'stk_push', $data_string);

    $decoded_curl_response = json_decode($curl_response, true);
    
    return $decoded_curl_response['CheckoutRequestID'];
}