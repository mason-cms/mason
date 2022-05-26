<?php

use Symfony\Component\HttpFoundation\Request;

return [

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    */

    'trusted' => env('TRUSTED_PROXIES'),

    /*
    |--------------------------------------------------------------------------
    | Proxy Header Set
    |--------------------------------------------------------------------------
    |
    */

    'header_set' => Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO,

];
