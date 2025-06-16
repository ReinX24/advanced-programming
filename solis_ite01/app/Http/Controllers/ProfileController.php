<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function index()
    {
        $greetings = 'Rein Solis';
        return view('profile', [
            'greetings' => $greetings
        ]);
    }
}
