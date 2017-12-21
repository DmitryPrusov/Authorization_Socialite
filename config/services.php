<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' =>env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('APP_URL') . '/oauth/facebook/callback',
        //'redirect' => 'http://localhost:8000/oauth/facebook/callback',

    ],
    'google' => [
        'client_id'     => env('GOOGLE_C_ID'),
        'client_secret' => env('GOOGLE_C_SECRET'),
    //    'redirect' => 'http://localhost:8000/oauth/google/callback',
        'redirect'      => env('APP_URL') . '/oauth/google/callback',
    ],



];