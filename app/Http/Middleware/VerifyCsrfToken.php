<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // API routes for frontend SPA (cart/checkout/products)
        'api/cart',
        'api/cart/*',
        'api/checkout',
        'api/checkout/*',
        'api/products',
        'api/products/*',
        'api/download',
        'api/verify-token',
    ];
}
