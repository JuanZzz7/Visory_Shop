<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only add headers if the response is an instance of Illuminate\Http\Response or similar
        if (method_exists($response, 'header')) {
            // Mitigate Clickjacking
            $response->header('X-Frame-Options', 'SAMEORIGIN');

            // Mitigate XSS attacks by forcing the browser to block the response if XSS is detected
            $response->header('X-XSS-Protection', '1; mode=block');

            // Prevent MIME-sniffing
            $response->header('X-Content-Type-Options', 'nosniff');

            // Protect privacy by strictly controlling the referrer information
            $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

            // Content Security Policy (CSP)
            // Relajado para permitir Bootstrap, AlpineJS y GSAP que usan estilos y scripts en línea
            $csp = "default-src 'self'; ";
            $csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://unpkg.com; ";
            $csp .= "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com https://unpkg.com; ";
            $csp .= "img-src 'self' data: https:; ";
            $csp .= "font-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com data: https://fonts.gstatic.com https://unpkg.com; ";
            $csp .= "connect-src 'self' https:; ";
            $csp .= "frame-src 'self' https://accounts.google.com;"; // Para permitir OAuth de Google
            
            $response->header('Content-Security-Policy', $csp);

            // Strict-Transport-Security (HSTS)
            // Obliga al navegador a comunicarse siempre por HTTPS (se asume que en producción se usa HTTPS)
            $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
            
            // Permissions-Policy: restringir acceso a APIs sensibles del dispositivo
            $response->header('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        }

        return $response;
    }
}
