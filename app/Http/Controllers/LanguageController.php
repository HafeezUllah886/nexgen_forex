<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     */
    public function switch(Request $request)
    {
        $request->validate([
            'lang' => 'required|string|in:en,ur,fa',
        ]);

        $lang = $request->lang;

        // Store in session
        Session::put('locale', $lang);

        // Also store direction in session
        Session::put('direction', $this->getDirection($lang));

        // Update user's language preference if logged in
        if (Auth::check()) {
            Auth::user()->update(['lang' => $lang]);
        }

        // Set the locale
        app()->setLocale($lang);

        return response()->json([
            'success' => true,
            'lang' => $lang,
            'direction' => $this->getDirection($lang),
        ]);
    }

    /**
     * Get the text direction for a language.
     */
    public static function getDirection(string $lang): string
    {
        // Urdu, Farsi (Persian), and Arabic are RTL
        return in_array($lang, ['fa', 'ar', 'ur']) ? 'rtl' : 'ltr';
    }

    /**
     * Check if a language is RTL.
     */
    public static function isRtl(string $lang): bool
    {
        return self::getDirection($lang) === 'rtl';
    }
}