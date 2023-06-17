<?php
use Carbon\Carbon;
use Dotenv\Dotenv;

function include_file($file_name) {
    require_once __DIR__ . '/' . $file_name . '.php';
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

$dotenv     = Dotenv::createImmutable(__DIR__)->load();
$timestamp  = Carbon::rawParse('now')->format('YmdHms');

$database_data = select_rows("SELECT * FROM MPESASHORTCODE WHERE mpesaShortCodeId = 'MSC20230617XCVD'")[0];

//from db
$passKey = $database_data['mpesaShortCodePassKey'];
$description = $database_data['mpesaShortCodeType']; 
$accountReference = $database_data['mpesaShortCodeName'];
$consumerKey = $database_data['mpesaShortCodeConsumerKey'];
$businessShortCode = $database_data['mpesaShortCodeValue'];
$consumerSecret = $database_data['mpesaShortCodeConsumerSecret'];

$password = lipaNaMpesaPassword($businessShortCode, $passKey, $timestamp);

$amount = 1;
$phoneNumber= '254798749323';

$stkValues = [
    'amount'            => $amount,
    'password'          => $password,
    'timestamp'         => $timestamp,
    'phoneNumber'       => $phoneNumber,
    'consumerKey'       => $consumerKey,
    'description'       => $description,
    'consumerSecret'    => $consumerSecret,
    'accountReference'  => $accountReference,
    'businessShortCode' => $businessShortCode
];

$CheckoutRequestID = stkPush($stkValues);

$stkStatusValues = [
    'password'          => $password,
    'timestamp'         => $timestamp,
    'consumerKey'       => $consumerKey,
    'consumerSecret'    => $consumerSecret,
    'CheckoutRequestID' => $CheckoutRequestID,
    'businessShortCode' => $businessShortCode
];

checkStkPush($stkStatusValues);