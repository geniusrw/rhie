<?php
use function Geniusrw\Rhie\Support\env;

return [
    'env' => env('HIE_ENV', 'production'),
    'url' => env('HIE_URL',),
    'username' => env('HIE_USERNAME'),
    'password' => env('HIE_PASSWORD'),

    'rhip' => [
        'url' => env('RHIP_URL'),
        'key' => env('RHIP_KEY'),
        'origin' => env('RHIP_ORIGIN'),
    ],
];
