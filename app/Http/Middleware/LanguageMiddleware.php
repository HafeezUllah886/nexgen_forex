<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LanguageController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (Auth::check()) {
            // Use user's preferred language from database
            $lang = Auth::user()->lang ?? 'en';
        } else {
            // Use session language or default to English
            $lang = session('locale', 'en');
        }

        // Set the application locale
        app()->setLocale($lang);

        // Store direction in session for easy access in views
        session(['direction' => LanguageController::getDirection($lang)]);

        // Share direction with all views
        view()->share('direction', LanguageController::getDirection($lang));
        view()->share('currentLang', $lang);

        return $next($request);
    }
}