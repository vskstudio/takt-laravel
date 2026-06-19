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
    'tagged' => env('TAKT_TAGGED', false),
    'not_found' => env('TAKT_NOT_FOUND', false),
    // Restrict download tracking to these extensions (comma-separated env, e.g.
    // "pdf,zip,docx"). Empty leaves the tracker's built-in extension list.
    'file_extensions' => array_filter(array_map('trim', explode(',', (string) env('TAKT_FILE_EXTENSIONS', '')))),
    'exclude_localhost' => env('TAKT_EXCLUDE_LOCALHOST', true),
    // CSP nonce for the inline <script>. A CSP nonce is request-scoped: set a
    // static one here only if your policy uses one, otherwise rebind the
    // SnippetRenderer per request with a fresh nonce.
    'nonce' => env('TAKT_NONCE'),
];
