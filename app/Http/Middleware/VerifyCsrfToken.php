<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'odeme-yap-sonuc','vakif-odeme-yap-basarisiz','odeme-yap', 'odeme-yap-basarili', 'odeme-yap-basarisiz', 'odeme-yap-2', 'odeme-yap-2-basarili', 'odeme-yap-2-basarisiz',
        'test-iyzico', 'odeme-yap-iyzico/*','odeme-yap-iyzico/*','odeme-yap2'
    ];
}
