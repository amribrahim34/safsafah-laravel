<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the Accept-Language header
        $locale = $request->header('Accept-Language');
        
        // Define supported locales
        $supportedLocales = ['ar', 'en'];
        
        // If locale is provided and supported, set it
        if ($locale && in_array($locale, $supportedLocales)) {
            app()->setLocale($locale);
        } else {
            // Default to 'en' if not provided or not supported
            app()->setLocale('en');
        }
        
        return $next($request);
    }
}
