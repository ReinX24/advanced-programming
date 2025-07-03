<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::apiResource('auth', LoginController::class);

Route::get('/auth/', [LoginController::class, 'index']);
Route::post('/auth/login', [LoginController::class, 'store']); // Login
Route::post('/auth/logout', [LoginController::class, 'logout'])
    ->middleware('auth:sanctum'); // Logout
