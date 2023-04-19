<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'getPolygonReport',
        'api/containment/{containcd}',
        'api/save-emptying-service',
        'api/save-assessment',
        'api/save-feedback'
    ];
}
