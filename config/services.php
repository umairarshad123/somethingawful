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

    /*
    |--------------------------------------------------------------------------
    | Google OAuth (Socialite — "Continue with Google")
    |--------------------------------------------------------------------------
    |
    | Set GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REDIRECT_URI in .env.
    | The redirect URI must match the one registered in your Google Cloud
    | Console OAuth client (e.g. https://your-domain.com/auth/google/callback
    | or http://localhost/DigiRisers/auth/google/callback for XAMPP).
    |
    */
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URI'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe — payments, subscriptions, customer portal
    |--------------------------------------------------------------------------
    |
    | All four values come from .env. Never hard-code keys.
    |
    |   STRIPE_KEY              publishable key (pk_test_... or pk_live_...)
    |   STRIPE_SECRET           secret key     (sk_test_... or sk_live_...)
    |   STRIPE_WEBHOOK_SECRET   whsec_...      (set after registering the
    |                                          webhook endpoint in Stripe)
    |   STRIPE_CURRENCY         3-letter ISO   (defaults to usd)
    */
    'stripe' => [
        'key'             => env('STRIPE_KEY'),
        'secret'          => env('STRIPE_SECRET'),
        'webhook_secret'  => env('STRIPE_WEBHOOK_SECRET'),
        'currency'        => env('STRIPE_CURRENCY', 'usd'),
    ],

];
