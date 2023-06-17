<?php

function newAccessToken(string $consumerKey, string $consumerSecret) : string
{
    $credentials = base64_encode($consumerKey . ":" .$consumerSecret);
    $curl_header = array("Authorization: Basic " . $credentials, "Content-Type:application/json");

    $curl_response = curl($_ENV['SAFARICOM_TOKEN_URL'], $curl_header, 'token');

    $access_token  = json_decode($curl_response);

    return $access_token->access_token;
}