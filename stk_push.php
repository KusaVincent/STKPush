<?php

function stkPush($amount, $phoneNumber, $dbh, $deposit, $propety_id, $func = "reg", $carbon_generated_timestamp)
{
    $paybill = 174379;
    $callback_url = $_ENV['CALLBACK_URL'];

    $url = $_ENV['SAFARICOM_PROCESS_REQUEST_URL'];

    $curl_post_data = [
        'BusinessShortCode' => $paybill,
        'Password'          => lipaNaMpesaPassword($carbon_generated_timestamp),
        'Timestamp'         => $carbon_generated_timestamp,
        'TransactionType'   => 'CustomerPayBillOnline',
        'Amount'            => $amount,
        'PartyA'            => $phoneNumber,
        'PartyB'            => $paybill,
        'PhoneNumber'       => $phoneNumber,
        'CallBackURL'       => $callback_url,
        'AccountReference'  => $_ENV['ACCOUNT_REFENCE'],
        'TransactionDesc'   => $_ENV['TRANSACTION_DESC']
    ];

    $data_string = json_encode($curl_post_data);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . newAccessToken()));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);

    $curl_response_decoded = json_decode($curl_response, true);
    $CheckoutRequestID = $curl_response_decoded['CheckoutRequestID'];

    check_stk_push($paybill, $carbon_generated_timestamp, $CheckoutRequestID, lipaNaMpesaPassword($carbon_generated_timestamp), $dbh, $deposit, $propety_id, $func);
}