<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Quotes API Configuration
    |--------------------------------------------------------------------------
    |
    | You can specify the base URL and rate-limiting settings here.
    | Values can be set via environment variables to allow flexibility.
    |
    */

    'base_url' => env('QUOTES_API_BASE_URL', 'https://dummyjson.com'),

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | These options control the rate limiting for requests to the Quotes API.
    | You can define how many requests are allowed within a given time window.
    |
    */

    'rate_limit' => env('QUOTES_API_RATE_LIMIT', 60),
    'window_time' => env('QUOTES_API_WINDOW_TIME', 60),
];
