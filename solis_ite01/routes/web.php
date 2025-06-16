<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('index');
});

// /account/Rein/edit
Route::get('/account/{fullname}', function ($fullname) {
    return "Hello $fullname";
});

// Profile routes
Route::get('/profile', [ProfileController::class, 'index']);

// Student routes
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/create', [StudentController::class, 'create'])->name("students.add");
Route::get('/students/{student}', [StudentController::class, 'show'])->name("students.show");
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name("students.edit");
Route::post('/students', [StudentController::class, 'store'])->name("students.store");
Route::patch('/students/{student}/update', [StudentController::class, 'update'])->name("students.update");
Route::delete("/students/{student}/delete", [StudentController::class, 'destroy'])->name("students.destroy");

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
