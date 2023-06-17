<?php

function check_stk_push($businessShortCode, $timestamp, $CheckoutRequestID, $password, $dbh, $deposit, $propety_id, $func)
{
    // global $CheckoutRequestID;

    //this code is used to check the transaction status of stk push

    $lipa_url       = $_ENV['SAFARICOM_LIPA_URL'];
    $headers        = ['Content-Type:application/json; charset=utf8'];

    $curl_          = curl_init();
    curl_setopt($curl_, CURLOPT_URL, $lipa_url);
    // $credentials = base64_encode('dbNnSKn8xaa3aA9R7lAAsGA0X7c0hjQ5:0lGsaLZ2P3WtHWdA');

    //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header

    curl_setopt($curl_, CURLOPT_HTTPHEADER, $headers); //setting a custom header

    curl_setopt($curl_, CURLOPT_HEADER, false);
    curl_setopt($curl_, CURLOPT_RETURNTRANSFER, true);

    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_, CURLOPT_USERPWD, $_ENV['CONSUMER_KEY'] . ':' . $_ENV['CONSUMER_SECRET']);

    $curl_response_ = curl_exec($curl_);

    // $access_token=$curl_response_->access_token;

    //echo  json_decode($curl_response)->access_token."</pre>";
    //echo $dde;
    $result       = json_decode($curl_response_);
    $access_token = $result->access_token;

    //echo $access_token;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $url = $_ENV['SAFARICOM_QUERY_URL'];

    //$businessShortCode='174379';
    //$password='MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMTkxMjE5MDEyMDUy';
    //$timestamp='20191219012052';
    //$checkoutRequestID='ws_CO_191220191621018035';

    $curl_ = curl_init();
    curl_setopt($curl_, CURLOPT_URL, $url);
    curl_setopt($curl_, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token));
    $curl_post_data = array(
        'BusinessShortCode' => $businessShortCode,
        'Password'          => $password,
        'Timestamp'         => $timestamp,
        'CheckoutRequestID' => $CheckoutRequestID
    );
    $data_string = json_encode($curl_post_data);
    curl_setopt($curl_, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_, CURLOPT_POST, true);
    curl_setopt($curl_, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($curl_, CURLOPT_HEADER, false);

    $curl_response_stk_response = curl_exec($curl_);

    $curl_dec_count             = json_decode($curl_response_stk_response, true);

    $curl_dec                   = json_decode($curl_response_stk_response);

    $count                      = sizeof($curl_dec_count);

    if ($count > 5) {
        $logs_success = fopen("mpesa_responses.json", "a");
        fwrite($logs_success, "\n\n\n" . $curl_response_stk_response . "\n");
        fclose($logs_success);

        $result_code         = $curl_dec->ResultCode;
        $checkout_request_id = $curl_dec->CheckoutRequestID;
        if ($func == "pay") {
            property_data_insert($deposit, $propety_id, $dbh, $checkout_request_id, $result_code);
        } elseif ($func == "reg") {
            user_data_insert($deposit, $propety_id, $dbh, $checkout_request_id, $result_code);
        }
    } else {
        check_stk_push($businessShortCode, $timestamp, $CheckoutRequestID, $password, $dbh, $deposit, $propety_id, $func);
        // Call your function to keep on checking for mpesa response
    }
}
