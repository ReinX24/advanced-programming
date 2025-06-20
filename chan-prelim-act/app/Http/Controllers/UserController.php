<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * index: Returns a view that lists all users.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * show($id): Accepts a user ID and returns a view showing the details of that specific user.
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', ['user' => $user]);
    }
}
