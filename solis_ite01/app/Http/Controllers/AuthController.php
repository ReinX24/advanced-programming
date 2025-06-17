<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Check if the user is already authenticated.
        // If they are, redirect them to a dashboard or home page.
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Or your desired authenticated redirect
        }

        return view('auth.login'); // Renders the login.blade.php view
    }

    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // 1. Validate the incoming request data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Attempt to authenticate the user
        // Auth::attempt takes an array of credentials and an optional boolean for "remember me"
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regeneration of session ID for security reasons
            $request->session()->regenerate();

            // Redirect to a dashboard or home page upon successful login
            return redirect()->route('dashboard')->withSuccess("Login successful!");
        }

        // 3. If authentication fails, throw a validation exception
        // This will send the user back to the form with an error message
        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Or your desired authenticated redirect
        }

        return view('auth.register'); // Renders the login.blade.php view
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        $data = $request->all();
        $user = User::create($data);

        Auth::login($user);

        return redirect()->route("dashboard")->withSuccess("Registration successful!");
    }

    /**
     * Log out the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Log out the user

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the login page or home page after logout
        return redirect()->route('login'); // Or your desired post-logout redirect
    }
}
