<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'age' => 'required|integer|min:13',
            'gender' => 'required|in:male,female',
            'educational_level' => 'required|in:elementary,high school,senior high,college',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'educational_level' => $validated['educational_level'],
        ]);

        Auth::login($user);

        return redirect()->route('content');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Add logging for last login update
            \Illuminate\Support\Facades\Log::info('User login successful', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
                'current_last_login' => Auth::user()->last_login_at
            ]);

            // Update last login time
            Auth::user()->updateLastLogin();

            // Log after update
            \Illuminate\Support\Facades\Log::info('Last login updated', [
                'user_id' => Auth::id(),
                'new_last_login' => Auth::user()->fresh()->last_login_at
            ]);

            // Check if user is admin
            if (Auth::user()->is_admin) {
                return redirect()->intended(route('user-manage'));
            }

            return redirect()->intended(route('content'));
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }

    public function logout(Request $request)
    {
        // Clear all session data
        $request->session()->flush();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Logout the user
        Auth::logout();

        // Clear any cached data
        $request->session()->forget(['user', 'settings', 'notifications']);

        // Set cache control headers for all authenticated routes
        $response = redirect()->route('show.login');

        // Add headers to prevent caching and back button access
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
        $response->headers->set('Clear-Site-Data', '"cache", "cookies", "storage"');

        return $response;
    }
}
