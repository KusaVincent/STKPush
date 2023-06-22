<?php

function lipaNaMpesaPassword(int $businessShortCode, string $passKey, string $currentTimestamp) : string
{
    return base64_encode($businessShortCode . $passKey . $currentTimestamp);
}