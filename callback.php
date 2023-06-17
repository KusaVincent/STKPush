<?php
header("Content-Type: application/json");

$mpesaResponse = file_get_contents('php://input');

require_once __DIR__ . '/mpesa_response.php';
writeMpesaLog($mpesaResponse, 'mpesaresponse');

$callbackData = json_decode($mpesaResponse);

$response = handleMpesaResponse($callbackData);
//variable pointers for the data comtained in the json send from safaricom
//balance has been excluded since we do nit need the balance and we dont get the value either
writeMpesaLog($response, 'result');