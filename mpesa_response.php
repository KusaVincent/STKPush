<?php

function handleMpesaResponse (object $callbackData) : array
{
  $resultCode         = $callbackData->Body->stkCallback->ResultCode;
  $resultDesc         = $callbackData->Body->stkCallback->ResultDesc;
  $metadata           = $callbackData->Body->stkCallback->CallbackMetadata;
  $merchantRequestID  = $callbackData->Body->stkCallback->MerchantRequestID;
  $checkoutRequestID  = $callbackData->Body->stkCallback->CheckoutRequestID;

  $amount             = $metadata->Item[0]->Value;
  $mpesaReceiptNumber = $metadata->Item[1]->Value;
  $transactionDate    = $metadata->Item[3]->Value;
  $phoneNumber        = $metadata->Item[4]->Value;
  
  $result = [
    "amount"             => $amount,
    "resultDesc"         => $resultDesc,
    "resultCode"         => $resultCode,
    "phoneNumber"        => $phoneNumber,
    "transactionDate"    => $transactionDate,
    "merchantRequestID"  => $merchantRequestID,
    "checkoutRequestID"  => $checkoutRequestID,
    "mpesaReceiptNumber" => $mpesaReceiptNumber
  ];
  
  if ($resultCode == 0) {
    writeMpesaLog($result, 'mpesa_response');
    return $result;
  }
  
  writeMpesaLog($result, 'mpesa_response');
  
  return $result;
}

function writeMpesaLog(array|string $result, string $fileName) : void
{
  $log = fopen($fileName . '.log', 'a');
  fwrite($log, "\n\n\n" . $result . "\n");
  fclose($log);
}