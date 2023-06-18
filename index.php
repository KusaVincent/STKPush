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
include_file('access_token');
include_file('helpers/index');
include_file('mpesa_response');
include_file('vendor/autoload');

Dotenv::createImmutable(__DIR__)->load();

function mpesa(array $paymentData) : array
{
    $timestamp      = Carbon::rawParse('now')->format('YmdHms');
    $accessToken    = newAccessToken($paymentData['consumerKey'], $paymentData['consumerSecret']);
    $password       = lipaNaMpesaPassword($paymentData['businessShortCode'], $paymentData['passKey'], $timestamp);

    $stkValues      = [
        'password'          => $password,
        'timestamp'         => $timestamp,
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

// $databaseData = select_rows("SELECT * FROM MPESASHORTCODE WHERE mpesaShortCodeId = '1'")[0];
// $samplePaymentData = [
//     'amount'            => 1,
//     'phoneNumber'       => '254798749323',
//     'accountReference'  => $databaseData['mpesaShortCodeName'],
//     'description'       => $databaseData['mpesaShortCodeType'],
//     'businessShortCode' => $databaseData['mpesaShortCodeValue'],
//     'passKey'           => $databaseData['mpesaShortCodePassKey'],
//     'consumerKey'       => $databaseData['mpesaShortCodeConsumerKey'],
//     'consumerSecret'    => $databaseData['mpesaShortCodeConsumerSecret'],
// ]; //fetching these from the database

// echo '<pre>';
// var_dump(mpesa($samplePaymentData));