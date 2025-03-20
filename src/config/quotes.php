<?php

return [
    'base_url' => env('QUOTES_API_BASE_URL', 'https://dummyjson.com'),
    'rate_limit' => env('QUOTES_API_RATE_LIMIT', 60),
    'window_time' => env('QUOTES_API_WINDOW_TIME', 60),
];
