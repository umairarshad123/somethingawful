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

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Sheets Lead Sync
    |--------------------------------------------------------------------------
    |
    | Each form posts to its own Google Apps Script web-app URL. Deploy an
    | Apps Script bound to your sheet (with appendRow on doPost(e)) then paste
    | the deployed "Web app URL" into the matching .env key below.
    |
    | .env keys to set:
    |   GSHEET_LEAD_URL          (main hero contact form)
    |   GSHEET_POPUP_URL         (lead-capture popup)
    |   GSHEET_SHARED_SECRET     (optional — Apps Script can verify before append)
    |   GSHEET_TIMEOUT           (optional — seconds, default 8)
    |
    */
    'gsheet' => [
        'lead_url'      => env('GSHEET_LEAD_URL'),
        'popup_url'     => env('GSHEET_POPUP_URL'),
        'shared_secret' => env('GSHEET_SHARED_SECRET'),
        'timeout'       => (int) env('GSHEET_TIMEOUT', 8),
    ],

];
