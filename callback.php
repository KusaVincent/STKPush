<?php
header("Content-Type: application/json");
require_once __DIR__ . '/mpesa_response.php';

$mpesaResponse = file_get_contents('php://input');

writeMpesaLog($mpesaResponse, 'mpesa_response');

$callbackData = json_decode($mpesaResponse);

$response = handleMpesaResponse($callbackData);
//variable pointers for the data comtained in the json send from safaricom
//balance has been excluded since we do nit need the balance and we dont get the value either

var_dump($response);