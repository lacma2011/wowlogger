<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Battle.net Api configuration
    |--------------------------------------------------------------------------
    */

    'region' => env('Battle_net_region', 'sea'),
    'api_url' => "https://". env('Battle_net_region', 'sea') .".api.battle.net",
    'api_url_cn' => "https://api.battle.com.cn/",
    'client_id' => env('Battle_net_client_id', ''),
    'client_secret' => env('Battle_net_client_secret', ''),
    'redirect_url' => env('APP_URL') . env('Battle_net_redirect_url', ''), //unused ?
    'scopes' => [
        'wow.profile',
        'sc2.profile'
    ],


    /*
    |--------------------------------------------------------------------------
    | Laravel Battle.net Api configuration *for xklusive/laravel-battlenet-api*
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Battle.net API credentials
    |--------------------------------------------------------------------------
    |
    | Before you be able to make requests to the Battle.net API, you need to provide your API key.
    | If you don't have an API key, refer to https://dev.battle.net/docs to get an API key
    |
    */

    'api_key' => env('Battle_net_client_id'),

    /*
    |--------------------------------------------------------------------------
    | Battle.net Locale
    |--------------------------------------------------------------------------
    |
    | Define what locale to use for the Battle.net API response.
    | For examples: en_GB | fr_FR | de_DE | ru_RU
    |
    */
    'locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Battle.net api domain
    |--------------------------------------------------------------------------
    |
    | Define the region API.
    | Change [region] by the value of your choice
    | You can refer to the Battle.net API documentation https://dev.battle.net/io-docs
    | For example, if you want to request on the Europe region: 'https://eu.api.battle.net'
    |
    */
    'domain' => "https://". env('Battle_net_region', 'sea') .".api.battle.net",

    /*
    |--------------------------------------------------------------------------
    | Battle.net api cache
    |--------------------------------------------------------------------------
    |
    | Define is the response body content is put in cache (default cache time is 10 hours),
    | using the cache driver for your application as specified by your cache configuration file.
    | Set it to false if you don't want that we manage cache.
    |
    */
    'cache' => true,

    /*
    |--------------------------------------------------------------------------
    | Battle.net api cache
    |--------------------------------------------------------------------------
    |
    | If cache is set to true, you can change here the cache time duration
    | This value is in minutes.
    |
    */
    'cache_duration' => 600,

];
