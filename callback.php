<?php
header("Content-Type: application/json");

$mpesaResponse = file_get_contents('php://input');

$log = fopen("confirm_M_PESARessponse_before.json", "a");
fwrite($log, "\n\n" . $mpesaResponse . "\n");
fclose($log);

//$data=json_encode($result);

//this returns an associative array of the json data received
$callbackDataaa = json_decode($mpesaResponse, true);

//this returns the decoded json data
$callbackData = json_decode($mpesaResponse);

//variable pointers for the data comtained in the json send from safaricom
//balance has been excluded since we do nit need the balance and we dont get the value either

$resultCode = $callbackData->Body->stkCallback->ResultCode;
$resultDesc = $callbackData->Body->stkCallback->ResultDesc;
$merchantRequestID = $callbackData->Body->stkCallback->MerchantRequestID;
$checkoutRequestID = $callbackData->Body->stkCallback->CheckoutRequestID;
$metadata = $callbackData->Body->stkCallback->CallbackMetadata;
$amount = $metadata->Item[0]->Value;
$mpesaReceiptNumber = $metadata->Item[1]->Value;
$balance = $metadata->Item[2]->Value;
$transactionDate = $metadata->Item[3]->Value;
$phoneNumber = $metadata->Item[4]->Value;

//one can also use this to point to the variables in the json data 

////////////////////////////////////////////////////////////////////////////////////////////
//logging the raw json response
$log = fopen("confirm_M_PESARessponse.txt", "a");
fwrite($log, "\n\n********" . $mpesaReceiptNumber . "\n........." . $mpesaResponse . "\n");
fclose($log);
/////////////////////////////////////////////////////////////////////////////////////////////

$result = [
  "resultDesc"         => $resultDesc,
  "resultCode"         => $resultCode,
  "merchantRequestID"  => $merchantRequestID,
  "checkoutRequestID"  => $checkoutRequestID,
  "amount"             => $amount,
  "mpesaReceiptNumber" => $mpesaReceiptNumber,
  "transactionDate"    => $transactionDate,
  "phoneNumber"        => $phoneNumber,
  "balance"            => $balance
];