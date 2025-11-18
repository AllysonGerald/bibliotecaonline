<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // X-Frame-Options: Previne clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');

        // X-Content-Type-Options: Previne MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // X-XSS-Protection: Proteção XSS (legado, mas ainda útil)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer-Policy: Controla informações de referrer
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions-Policy: Controla features do navegador
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // Content-Security-Policy: Política de segurança de conteúdo
        // Permite CDNs necessários para Alpine.js e Lucide Icons
        // Usando política mais permissiva para permitir scripts externos
        $csp = "default-src 'self' https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com https:; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https:; img-src 'self' data: https:; font-src 'self' data: https:; connect-src 'self' https:;";
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
