<?php

function checkStkPush(array $stkStatusValues) : array
{
    $stkCurlResponse = checkStkPushStatus($stkStatusValues);
    $decodedStkResponse= json_decode($stkCurlResponse, true);

    if (!$decodedStkResponse || sizeof($decodedStkResponse) < 6) {
        return checkStkPush($stkStatusValues);
        // Call your function to keep on checking for mpesa response
    } 

    $log = fopen("mpesa_response.log", "a");
    fwrite($log, "\n\n\n" . $stkCurlResponse . "\n");
    fclose($log);

    $resultCode         = $decodedStkResponse['ResultCode'];
    $CheckoutRequestID  = $decodedStkResponse['CheckoutRequestID'];

    return checkoutResponse($resultCode, $CheckoutRequestID);
}

function checkStkPushStatus(array $stkStatusValues) : mixed
{
    $curlPostData = array(
        'Password'          => $stkStatusValues['password'],
        'Timestamp'         => $stkStatusValues['timestamp'],
        'BusinessShortCode' => $stkStatusValues['businessShortCode'],
        'CheckoutRequestID' => $stkStatusValues['CheckoutRequestID']
    );

    $curlHeader  = array('Content-Type:application/json', 'Authorization:Bearer ' . $stkStatusValues['accessToken']);

    return curl($_ENV['SAFARICOM_QUERY_URL'], $curlHeader, 'stk_status_response', json_encode($curlPostData));
}