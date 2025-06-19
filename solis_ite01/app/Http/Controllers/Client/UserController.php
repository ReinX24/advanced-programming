<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view("client.users.index", ["users" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("client.users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => bcrypt($data["password"]),
        ]);

        return redirect()->route("users.show", $user->id)->withSuccess("Added user successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view("client.users.show", ["user" => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view("client.users.edit", ["user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        $user->update([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => bcrypt($data["password"]),
        ]);

        return redirect()->route("users.show", $user)->withSuccess("Updated user successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        // Logout account if the user will be deleting their own account
        if (Auth::user()->id == $user->id) {
            Auth::logout(); // Log out the user

            // Invalidate the session
            $request->session()->invalidate();

            // Regenerate the CSRF token
            $request->session()->regenerateToken();
        }

        $user->delete();

        return redirect()->route("users.index")->with("success", "User deleted successfully");
    }
}
