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
        'visitors/save',
        'articles/receive',
        'product/*',
        'payfast/notify',
        'ozow/notify',
        'reviews/*',
        'contacts/process',
        'contacts/save',
        'contacts/agents',
    ];
}
