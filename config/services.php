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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'yahoo_finance' => [
        'api_key' => env('YAHOO_FINANCE_API_KEY'),
        'host' => env('YAHOO_FINANCE_API_HOST', 'yahoo-finance-real-time1.p.rapidapi.com'),
        'timeout' => env('YAHOO_FINANCE_TIMEOUT', 10),
        'region' => env('YAHOO_FINANCE_DEFAULT_REGION', 'US'),
        'lang' => env('YAHOO_FINANCE_DEFAULT_LANGUAGE', 'en-US'),
        'cache_store' => env('YAHOO_FINANCE_CACHE_STORE'),
        'cache_ttl' => env('YAHOO_FINANCE_CACHE_TTL', 900),
    ],

];
