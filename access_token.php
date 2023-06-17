<?php

function newAccessToken() : string
{
    $url               = $_ENV['SAFARICOM_URL'];
    $credentials       = base64_encode($_ENV['CONSUMER_KEY'] . ":" . $_ENV['CONSUMER_SECRET']);

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $credentials, "Content-Type:application/json"));
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    $access_token = json_decode($curl_response);

    curl_close($curl);

    return $access_token->access_token;
}