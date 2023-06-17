<?php
use Carbon\Carbon;
use Dotenv\Dotenv;

function include_file($file_name) {
    require_once __DIR__ . '/' . $file_name . '.php';
}

include_file('vendor/autoload');

$dotenv     = Dotenv::createImmutable(__DIR__)->load();
$timestamp  = Carbon::rawParse('now')->format('YmdHms');

include_file('response');
include_file('password');
include_file('stk_push');
include_file('callback');
include_file('stk_status');
include_file('access_token');