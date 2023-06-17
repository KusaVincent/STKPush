<?php
use Carbon\Carbon;
use Dotenv\Dotenv;

function include_file($file_name) {
    require_once __DIR__ . '/' . $file_name . '.php';
}

include_file('response');
include_file('password');
include_file('stk_push');
include_file('callback');
include_file('stk_status');
include_file('access_token');
include_file('vendor/autoload');

$dotenv     = Dotenv::createImmutable(__DIR__)->load();
$timestamp  = Carbon::rawParse('now')->format('YmdHms');

//from db
$businessShortCode = 174379;
$description = 'Lipa na Mpesa'; 
$accountReference = $_ENV['ACCOUNT_REFENCE'];
$consumerKey = $_ENV['CONSUMER_KEY'];
$consumerSecret = $_ENV['CONSUMER_SECRET'];
$passKey = $_ENV['SAFARICOM_PASS_KEY'];

$password = lipaNaMpesaPassword($businessShortCode, $passKey, $timestamp);

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