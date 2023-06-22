<?php
use Carbon\Carbon;
use Dotenv\Dotenv;

function include_file($fileName) {
    require_once __DIR__ . '/' . $fileName . '.php';
}

include_file('curl');
include_file('response');
include_file('password');
include_file('stk_push');
include_file('stk_status');
include_file('input_sanity');
include_file('phone_number');
include_file('access_token');
include_file('helpers/index');
include_file('mpesa_response');
include_file('vendor/autoload');

Dotenv::createImmutable(__DIR__)->load();

function mpesa(array $paymentData) : array
{
    $currentTimestamp   = Carbon::rawParse('now')->format('YmdHms');
    $accessToken        = newAccessToken($paymentData['consumerKey'], $paymentData['consumerSecret']);
    $password           = lipaNaMpesaPassword($paymentData['businessShortCode'], $paymentData['passKey'], $currentTimestamp);

    $stkValues      = [
        'password'          => $password,
        'timestamp'         => $currentTimestamp,
        'accessToken'       => $accessToken,
        'amount'            => $paymentData['amount'],
        'phoneNumber'       => $paymentData['phoneNumber'],
        'description'       => $paymentData['description'],
        'accountReference'  => $paymentData['accountReference'],
        'businessShortCode' => $paymentData['businessShortCode']
    ];

    $stkStatusValues    = array_slice($stkValues, 0, 4, true);
    $stkStatusValues   += array_slice($stkValues, 7, 1, true);

    $stkStatusValues['CheckoutRequestID'] = stkPush($stkValues);

    return checkStkPush($stkStatusValues);
}

// $databaseData = select_rows("SELECT * FROM MPESASHORTCODE WHERE mpesaShortCodeId = 'MSC20230617XCVD'")[0];

// $samplePaymentData = array();

// $amount = '1';
// $phoneNumber    = formatPhoneNumber('0798749323');

// if(sanitizeSTKData($phoneNumber))                                                           $samplePaymentData['phoneNumber'] = $phoneNumber;
// if(sanitizeSTKData($amount, ['numeric']))                                       $samplePaymentData['amount'] = $amount;
// if(sanitizeSTKData($databaseData['mpesaShortCodeName'], ['string']))            $samplePaymentData['accountReference'] = $databaseData['mpesaShortCodeName'];
// if(sanitizeSTKData($databaseData['mpesaShortCodeType'], ['string']))            $samplePaymentData['description'] = $databaseData['mpesaShortCodeType'];
// if(sanitizeSTKData($databaseData['mpesaShortCodeValue'], ['number']))           $samplePaymentData['businessShortCode'] = $databaseData['mpesaShortCodeValue'];
// if(sanitizeSTKData($databaseData['mpesaShortCodePassKey'], ['string']))         $samplePaymentData['passKey'] = $databaseData['mpesaShortCodePassKey'];
// if(sanitizeSTKData($databaseData['mpesaShortCodeConsumerKey'], ['string']))     $samplePaymentData['consumerKey'] = $databaseData['mpesaShortCodeConsumerKey'];
// if(sanitizeSTKData($databaseData['mpesaShortCodeConsumerSecret'], ['string']))  $samplePaymentData['consumerSecret'] = $databaseData['mpesaShortCodeConsumerSecret'];

// echo '<pre>';
// var_dump(($samplePaymentData));