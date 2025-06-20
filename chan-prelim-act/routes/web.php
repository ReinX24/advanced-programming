<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * A route for the homepage (/) that returns a view named welcome.
 */
Route::get('/', function () {
    return view('welcome');
});

/**
 * A route for an about page (/about) that returns a string "About Us".
 */
Route::get('/about', function () {
    return "About Us";
});

/**
 * A route for a contact page (/contact) that returns a string "Contact Us".
 */
Route::get('/contact', function () {
    return "Contact Us";
});

/**
 * Create a route that takes a parameter, such as a user ID. For example:
 * /user/{id}. This route should return a string that says "User ID is {id}".
 */
Route::get('/user/{id}', function ($id) {
    return "User id is $id";
});

/**
 * Update your routes/web.php file to connect the routes for the user listing and user detail to the corresponding methods in UserController.
 * Route to the index method: /users
 * Route to the show method: /users/{id}
 */
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
