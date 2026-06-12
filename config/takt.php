<?php

return [
    'domain' => env('TAKT_DOMAIN', ''),
    'endpoint' => env('TAKT_ENDPOINT', 'https://takt.example.com'),
    'api_key' => env('TAKT_API_KEY'),
    'mode' => env('TAKT_MODE', 'inline'),
    'outbound' => env('TAKT_OUTBOUND', false),
    'files' => env('TAKT_FILES', false),
    'exclude_localhost' => env('TAKT_EXCLUDE_LOCALHOST', true),
];
