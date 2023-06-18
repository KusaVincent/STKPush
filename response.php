<?php

function checkoutResponse(int $resultCode, string $CheckoutRequestID) : array
{
    $result = array();
    $result['CheckoutRequestID'] = null;

    switch($resultCode) {
        case 0:
            $result['paymentResponse'] = "successful";
            $result['CheckoutRequestID'] = $CheckoutRequestID;
            break;
        case 1:
            $result['paymentResponse'] = "insufficient";
            break;
        case 1032:
            $result['paymentResponse'] = "cancelled";
            break;
        case 1037:
            $result['paymentResponse'] = "timeout";
            break;
        default:
            $result['paymentResponse'] = "error";
    }

    return $result;
}