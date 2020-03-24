<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '627767614:AAHDCgHazG-dteuIPovLps2eNc8IRZ57V0w/webhook',
        '*/627767614:AAHDCgHazG-dteuIPovLps2eNc8IRZ57V0w/webhook',
        'bot*'
    ];
}
