<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm(Request $request)
    {
        // Check if language is specified in query string
        if ($request->has('lang') && in_array($request->lang, ['en', 'ur', 'fa'])) {
            $lang = $request->lang;
            app()->setLocale($lang);
            $request->session()->put('locale', $lang);
        } else {
            // Use session language or default to English
            $lang = $request->session()->get('locale', 'en');
            app()->setLocale($lang);
        }

        // Set direction in session (Urdu, Farsi, Arabic are RTL)
        $direction = in_array($lang, ['fa', 'ar', 'ur']) ? 'rtl' : 'ltr';
        $request->session()->put('direction', $direction);

        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // Find user by username
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors([
                'username' => __('auth.invalid_credentials'),
            ])->withInput($request->except('password'));
        }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'username' => __('auth.invalid_credentials'),
            ])->withInput($request->except('password'));
        }

        // Log in the user
        Auth::login($user);

        // Set locale based on user's preferred language
        $lang = $user->lang ?? 'en';
        app()->setLocale($lang);
        $request->session()->put('locale', $lang);

        $request->session()->regenerate();

        return redirect()->intended('/dashboard')->with('success', __('auth.welcome') . ', ' . ($user->name ?? $user->username) . '!');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', __('auth.logged_out'));
    }
}