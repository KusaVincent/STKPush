<?php
header("Content-Type: application/json");

$mpesaResponse = file_get_contents('php://input');

require_once __DIR__ . '/mpesa_response.php';
writeMpesaLog($mpesaResponse, 'mpesa_response');

$callbackData = json_decode($mpesaResponse);

$response = handleMpesaResponse($callbackData);

writeMpesaLog($response, 'mpesa_response');