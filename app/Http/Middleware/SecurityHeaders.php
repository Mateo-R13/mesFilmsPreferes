<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 🔒 Empêche le clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 🔒 Empêche le sniffing MIME
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 🔒 Force HTTPS en production
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        // 🔒 Contrôle les infos envoyées dans le Referer
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 🔒 Désactive les fonctionnalités navigateur inutiles
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // 🔒 XSS protection (legacy browsers)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        return $response;
    }
}
