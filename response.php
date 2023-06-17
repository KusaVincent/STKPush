<?php

function checkout(int $result_code, string $checkout_request_id) : array
{
    $results = array();
    $results['checkout_request_id'] = null;

    switch($result_code) {
        case 0:
            $results['server_response'] = "successful";
            $results['checkout_request_id'] = $checkout_request_id;
            break;
        case 1037:
            $results['server_response'] = "timeout";
            break;
        case 1032:
            $results['server_response'] = "cancelled";
            break;
        default:
            $results['server_response'] = "limited";
    }

    return $results;
}