<?php

function handleMpesaResponse (array $callbackData) : array
{
  $resultCode         = $callbackData['Body']['stkCallback']['ResultCode'];
  $checkoutRequestID  = $callbackData['Body']['stkCallback']['CheckoutRequestID'];
  $metadata           = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'];

  $result = array_column($metadata, 'Value', 'Name');
  $result["checkoutRequestID"] = $checkoutRequestID;
  
  if ($resultCode == 0) {
    writeMpesaLog($result, 'mpesa_response');
    return $result;
  }
  
  writeMpesaLog($result, 'mpesa_response');
  
  return $result;
}

function writeMpesaLog(mixed $result, string $fileName) : void
{
  $log = fopen($fileName . '.log', 'a');
  fwrite($log, "\n\n\n" . json_encode($result) . "\n");
  fclose($log);
}