<?php

return [
    'domain' => env('TAKT_DOMAIN', ''),
    'endpoint' => env('TAKT_ENDPOINT', 'https://takt.example.com'),
    // First-party origin to serve the tracker + derive the endpoint from
    // ({origin}/api/event) — your Takt domain or a custom domain to dodge
    // ad-blockers (endpoint wins over it).
    'script_origin' => env('TAKT_SCRIPT_ORIGIN'),
    'api_key' => env('TAKT_API_KEY'),
    'mode' => env('TAKT_MODE', 'inline'),
    'outbound' => env('TAKT_OUTBOUND', false),
    'files' => env('TAKT_FILES', false),
    'exclude_localhost' => env('TAKT_EXCLUDE_LOCALHOST', true),
];
