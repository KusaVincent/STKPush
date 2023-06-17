<?php

function lipaNaMpesaPassword(string $timestamp) : string
{
    $businessShortCode = 174379; //store in db
    $mpesaPassword     = base64_encode($businessShortCode . $_ENV['SAFARICOM_PASS_KEY'] . $timestamp);

    return $mpesaPassword;
}
