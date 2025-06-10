<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('index');
});

// /account/Rein/edit
Route::get('/account/{fullname}', function ($fullname) {
    return "Hello $fullname";
});

Route::get('/profile', function () {
    $greetings = 'Rein Solis';
    return view('profile', [
        'greetings' => $greetings
    ]);
});

Route::get('/students', function () {
    $data["students"] = [
        ['name' => 'Nikole'],
        ['name' => 'Lexine'],
        ['name' => 'Andrea'],
    ];

    $data["isAdmin"] = true;

    $data["user"] = "Rein Solis";

    return view('students', $data);
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
