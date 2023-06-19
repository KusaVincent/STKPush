<?php

function newAccessToken(string $consumerKey, string $consumerSecret) : string
{
    $credential = base64_encode($consumerKey . ":" .$consumerSecret);
    $curlHeader = array("Authorization: Basic " . $credential, "Content-Type:application/json");

    $curlResponse = curl($_ENV['SAFARICOM_TOKEN_URL'], $curlHeader, 'token');

    $accessToken  = json_decode($curlResponse);

    return $accessToken->access_token;
}