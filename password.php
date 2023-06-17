<?php

function lipaNaMpesaPassword(int $businessShortCode, string $passKey, string $timestamp) : string
{
    return base64_encode($businessShortCode . $passKey . $timestamp);
}