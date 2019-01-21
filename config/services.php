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
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],


    //Soialite providers
    //--------------
    'battlenet-stateful' => [
        'client_id' => env('Battle_net_client_id'),
        'client_secret' => env('Battle_net_client_secret'),
        'redirect' => env('APP_URL') . ':' . env('APP_PORT') . '/' . env('Battle_net_redirect_url'),

        // extra -- battle.net has multiple authentication endpoints by region!
        'region' => env('Battle_net_region'),
        'scopes' => 'wow.profile',
    ],
    //end Socialite providers
    //------------------
    
    
    'selenium' => [
        'host' => env('SELENIUM_HOST'),
        'port' => env('SELENIUM_PORT'),
    ],


];
