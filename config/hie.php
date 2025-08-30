<?php
use function Genius\Rhie\Support\env;

return [
    'env' => env('HIE_ENV', 'production'),
    'url' => env('HIE_URL',),
    'username' => env('HIE_USERNAME'),
    'password' => env('HIE_PASSWORD'),
];
