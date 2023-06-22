# Safaricom STK Pushk

---
**Table of contents**
1. Set up
2. understand the code
---
## Set up 
1. ### Prerequisite
    1. Ensure you have php and composer
    2. run 
        ```php
            composer install
        ``` 
        to get all project dependancies installed.
        ##### dependancies
        1. Carbon - for current timestamp.
        2. DotDev - to help with .env imports.
2. ### .env file
    Create a file named `.env`
    This file contain the app static data.
    To import it, copy the below code and customize it to match your data.
    ```env
        # DATABASE CONNECTION
        DB_NAME=''
        DB_PASSWORD=''
        DB_USERNAME=''
        DB_HOST=''

        APP_NAME=''
        COUNTRY_CODE=254
        CALLBACK_URL=''

        SAFARICOM_QUERY_URL=https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query
        SAFARICOM_ENDPOINT_URL=https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest
        SAFARICOM_TOKEN_URL=https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials
    ```
    Current URLs are as per Safaricom daraja tests.
---
## Understand the Code
1. #### Code Entry
    Code entry point is index.php, call the function `mpesa` the fuction accepts one param of type array.
    `example of accepted array is commented in index.php`.
1. ### stkPush
    This function is responsible for generating the STK Push on the customer's device, it expects:
    1. Amount
    1. Password
    1. Timestamp
    1. CallBackURL
    1. TransactionDesc
    1. PhoneNumber
    1. PartyA
    1. TransactionType
    1. AccountReference
    1. PartyB
    1. BusinessShortCode


   #### Password
     `lipaNaMpesaPassword` function is used to generate password, it accepts `shortcode`, `current timestamp`, and  `passkey` given when you go live with the shortcode in the `developer.safaricom` daraja portal.
   #### Timestamp
    `Timestamp` which is generated using `Carbon` library, use can use any method for this though, so long you come up with an authentic timestamp. Carbon provides a simpler and more expressive way to work with dates and timestamps compared to the standard `date()` function hence the choice for me.
    #### Callback
   `CallbackURL` specifies to Safaricom where you want the callback/response to be routed.
    #### BusinessShortCode
   `BusinessShortCode` get this from Safaricom before even stating the process, `passkey` is tied to the shortcode whereas `consumer key` and `consumer secret` is tied to the app created in daraja.

## More Functions
1. #### newAccessToken
1. #### curl
1. #### checkStkPush
1. #### checkStkPushStatus
1. #### checkoutResponse
1. #### formatPhoneNumber
1. #### sanitizeSTKData
1. #### writeMpesaLog
1. #### handleMpesaResponse

   