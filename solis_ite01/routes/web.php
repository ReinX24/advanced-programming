<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\AppointmentController;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Client\StudentController;
use App\Mail\AppointmentCreated;
use App\Mail\HelloMail;
use App\Models\Student;
use App\Models\User;
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
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth')->middleware('auth');

//* Profile routes, using a resource controller
Route::resource('profile', ProfileController::class)->middleware('auth');

Route::prefix('client')->group(function () {
    //* Users routes
    Route::resource('users', UserController::class);
    //* Student routes
    Route::resource('students', StudentController::class);
    //* Appointment routes
    Route::resource('appointments', AppointmentController::class);

    Route::patch('/appointments/{appointment}/toggleStatus', [AppointmentController::class, 'toggleStatus'])->name('appointments.toggleStatus');
})->middleware('auth');

//* Test route to be used for layout and styling testing
Route::get('/test', function () {
    return view('test');
});

Route::get('/mailtest', function () {
    Mail::to('reinX244@gmail.com')->send(new HelloMail());
});
