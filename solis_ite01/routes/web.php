<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\UserController;
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
// Route::resource('profile', ProfileController::class)->middleware('auth')->except('index');

// Route::get('/profile', function () {
//     return view('profile.index');
// })->name('profile.index');

//* Student routes
// Route::resource('students', StudentController::class)->middleware('auth')->except('index');

// Route::get('/students', function () {
//     return view("students.index", [
//         'isAdmin' => true,
//         'students' => Student::latest()->paginate(10)
//     ]);
// })->name('students.index');

Route::prefix('client')->group(function () {
    Route::resource('users', UserController::class);
})->middleware('auth');

//* Test route to be used for layout and styling testing
Route::get('/test', function () {
    return view('test');
});
