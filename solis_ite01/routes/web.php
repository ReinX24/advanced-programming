<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');

Route::get('/dashboard', function () {
    $studentCount = Student::all()->count();
    $profileCount = User::all()->count();

    return view('index', [
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

//* Student routes
Route::resource('students', StudentController::class)->middleware('auth');
