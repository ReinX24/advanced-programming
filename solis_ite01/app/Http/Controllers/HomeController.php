<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
        $studentCount = Student::all()->count();
        $profileCount = User::all()->count();

        return view('dashboard', [
            'studentCount' => $studentCount,
            'profileCount' => $profileCount
        ]);
    }
}
