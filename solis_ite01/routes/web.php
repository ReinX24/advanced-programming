<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\AppointmentController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\StudentController;
use App\Http\Controllers\OtpLoginController;
use App\Mail\AppointmentCreated;
use App\Mail\HelloMail;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');

Route::get('/dashboard', function () {
    $studentCount = Student::all()->count();
    $profileCount = User::all()->count();

    return view('dashboard', [
        'studentCount' => $studentCount,
        'profileCount' => $profileCount
    ]);
})->name('dashboard')->middleware('auth');

//* Auth routes
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
// Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
// Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
// Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('guest');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth')->middleware('auth');

Route::prefix('client')->group(function () {
    //* Users routes
    Route::resource('users', UserController::class);
    //* Student routes
    Route::resource('students', StudentController::class);
    //* Appointment routes
    Route::resource('appointments', AppointmentController::class);

    Route::patch('/appointments/{appointment}/toggleStatus', [AppointmentController::class, 'toggleStatus'])->name('appointments.toggleStatus');

    //* Profile routes, using a resource controller
    Route::resource('profile', ProfileController::class);
})->middleware('auth');

//* Test route to be used for layout and styling testing
Route::get('/test', function () {
    return view('test');
});

Route::get('/mailtest', function () {
    Mail::to('reinX244@gmail.com')->send(new HelloMail());
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Show the initial OTP login form (where user enters email)
Route::get('/otp/login', [OtpLoginController::class, 'showLoginForm'])->name('otp.login');
Route::post('/otp/send', [OtpLoginController::class, 'sendOtp'])->name('otp.send');

// Show the OTP verification form (where user enters OTP)
Route::get('/otp/verify', [OtpLoginController::class, 'showOtpVerificationForm'])->name('otp.verify.form');
Route::post('/otp/verify', [OtpLoginController::class, 'verifyOtp'])->name('otp.verify');

Route::get('/test', function (Request $request) {
    return "Test";
})->middleware('auth:sanctum');
