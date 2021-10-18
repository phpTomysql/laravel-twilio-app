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
        'twilio/webhook',
        'twilio/webhook/q1',
        'twilio/webhook/q2',
        'twilio/webhook/q3',
    ];
}
