<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_AUTH_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],

    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
        'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),
    ],

    'jazzcash' => [
        'merchant_id' => env('JAZZCASH_MERCHANT_ID', ''),
        'password' => env('JAZZCASH_PASSWORD', ''),
        'integrity_salt' => env('JAZZCASH_INTEGRITY_SALT', ''),
        'sandbox' => env('JAZZCASH_SANDBOX', true),
        'sandbox_url' => env('JAZZCASH_SANDBOX_URL', 'https://sandbox.jazzcash.com.pk/Application/index.php/api/MWALLET/Pay'),
        'live_url' => env('JAZZCASH_LIVE_URL', 'https://payments.jazzcash.com.pk/Application/index.php/api/MWALLET/Pay'),
        'return_url' => env('JAZZCASH_RETURN_URL', ''),
    ],

    'easypaisa' => [
        'store_id' => env('EASYPAISA_STORE_ID', ''),
        'hash_key' => env('EASYPAISA_HASH_KEY', ''),
        'sandbox' => env('EASYPAISA_SANDBOX', true),
        'sandbox_url' => env('EASYPAISA_SANDBOX_URL', 'https://easypaystg.easypaisa.com.pk/easypay-service/rest/v4/initiate-ma-transaction'),
        'live_url' => env('EASYPAISA_LIVE_URL', 'https://easypay.easypaisa.com.pk/easypay-service/rest/v4/initiate-ma-transaction'),
        'post_back_url' => env('EASYPAISA_POST_BACK_URL', ''),
    ],

    'payfast' => [
        'merchant_id' => env('PAYFAST_MERCHANT_ID', ''),
        'secured_key' => env('PAYFAST_SECURED_KEY', ''),
        'hash_key' => env('PAYFAST_HASH_KEY', ''),
        'sandbox' => env('PAYFAST_SANDBOX', true),
        'sandbox_url' => env('PAYFAST_SANDBOX_URL', 'https://uat.premierpayfast.com'),
        'live_url' => env('PAYFAST_LIVE_URL', 'https://api.premierpayfast.com'),
    ],

];
