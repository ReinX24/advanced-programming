<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

//* Index route
Route::get('/', function () {
    return view('index');
});

//* Profile routes, using a resource controller
Route::resource('profile', ProfileController::class);

//* Student routes
Route::resource('students', StudentController::class);

// Test routes
// /account/Rein
Route::get('/account/{fullname}', function ($fullname) {
    return "Hello $fullname";
});

Route::get('/test', function () {
    $fname = 'Rein';
    $lname = 'Solis';

    return view('index', [
        'fname' => $fname,
        'lname' => $lname
    ]);
});

Route::get('/contacts', function () {
    return "This is the contacts page";
});

Route::get('/users', function () {
    dd(User::all());
});
