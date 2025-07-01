<?php

namespace App\Http\Controllers;

use App\Jobs\SendOtpEmailJob;
use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class OtpLoginController extends Controller
{
    /**
     * Show the OTP login form.
     */
    public function showLoginForm()
    {
        return view('auth.otp-login');
    }

    /**
     * Handle the initial email submission for OTP.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP in the user record with an expiry time (e.g., 5 minutes)
        $user->otp = Hash::make($otp); // Hash the OTP for security
        $user->otp_expires_at = Carbon::now()->addMinutes(5);
        $user->save();

        // Send OTP via email using Notification
        // $user->notify(new OtpNotification($otp));

        // Send OTP via email using Job
        SendOtpEmailJob::dispatch($user->email, $otp)->delay(now()->addSeconds(5));

        return redirect()->route('otp.verify.form', ['email' => $user->email])
            ->with('status', 'An OTP has been sent to your email address.');
    }

    /**
     * Show the OTP verification form.
     */
    public function showOtpVerificationForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        return view('auth.otp-verify', ['email' => $request->email]);
    }

    /**
     * Verify the OTP and log in the user.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if OTP exists, is not expired, and matches
        if (!$user || !Hash::check($request->otp, $user->otp) || Carbon::now()->isAfter($user->otp_expires_at)) {
            throw ValidationException::withMessages([
                'otp' => ['The provided OTP is invalid or has expired.'],
            ]);
        }

        // OTP is valid, log in the user
        Auth::login($user);

        // Clear the OTP fields after successful login for security
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        $request->session()->regenerate();

        return redirect()->intended('/dashboard'); // Or wherever you want to redirect
    }
}
