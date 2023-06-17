<?php

function checkStkPush(array $stkStatusValues) : void
{
    $stk_curl_response = checkStkPushStatus($stkStatusValues);
    $decodedStkResponse= json_decode($stk_curl_response, true);

    if ($decodedStkResponse && sizeof($decodedStkResponse) > 5) {
        $logs_success = fopen("mpesa_response.log", "a");
        fwrite($logs_success, "\n\n\n" . $stk_curl_response . "\n");
        fclose($logs_success);

        $result_code         = $decodedStkResponse['ResultCode'];
        $checkout_request_id = $decodedStkResponse['CheckoutRequestID'];

        checkout($result_code, $checkout_request_id);
    } else {
        checkStkPush($stkStatusValues);
        // Call your function to keep on checking for mpesa response
    }
}

function checkStkPushToken(string $consumerKey, string $consumerSecret) : string
{
    $headers        = ['Content-Type:application/json; charset=utf8'];
    $curl_response  = curl($_ENV['SAFARICOM_TOKEN_URL'], $headers, 'stk_status_token', $consumerKey . ':' . $consumerSecret);

    $result_response= json_decode($curl_response);

    return $result_response->access_token;
}

function checkStkPushStatus(array $stkStatusValues) : mixed
{
    $curl_post_data = array(
        'Password'          => $stkStatusValues['password'],
        'Timestamp'         => $stkStatusValues['timestamp'],
        'BusinessShortCode' => $stkStatusValues['businessShortCode'],
        'CheckoutRequestID' => $stkStatusValues['CheckoutRequestID']
    );

    $consumerKey    = $stkStatusValues['consumerKey'];
    $consumerSecret = $stkStatusValues['consumerSecret'];

    $access_token = checkStkPushToken($consumerKey, $consumerSecret);
    $curl_header  = array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token);

    return curl($_ENV['SAFARICOM_QUERY_URL'], $curl_header, 'stk_status_response', json_encode($curl_post_data));
}