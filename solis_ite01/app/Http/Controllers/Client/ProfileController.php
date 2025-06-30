<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client.profile.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, string $id)
    {
        $data = $request->validated();

        $user = User::find($id);

        $photoPath = $user->profile_photo_path; // Keep existing path by default

        // Handle profile photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Store the new photo
            // The 'public' disk stores files in storage/app/public/photos
            // and returns a path like 'photos/unique_filename.jpg'
            // $photoPath = $request->file('photo')->store('photos', 'public');

            // Get the uploaded file
            $file = $request->file('photo');

            // Generate a unique filename using a combination of user ID and a random string
            // Get the original file extension
            $extension = $file->extension(); // Gets the file extension (e.g., 'jpg', 'png')
            $fileName = $user->id . '_' . Str::random(10) . '.' . $extension; // Example: 1_dsfg4hjk1l.jpg

            // Define the storage directory within the 'public' disk
            $directory = 'profile-photos'; // Or 'photos' as you had before

            // Store the new photo with a custom name
            // This will save the file to storage/app/public/profile-photos/1_dsfg4hjk1l.jpg
            $photoPath = $file->storeAs($directory, $fileName, 'public');
        } elseif ($request->input('clear_photo')) {
            // Option to clear the photo (if you add a checkbox for it)
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $photoPath = null;
        }

        $user->update([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => bcrypt($data["password"]),
            "profile_photo_path" => $photoPath,
        ]);

        return redirect()->route("profile.index")->withSuccess("Updated profile successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        User::find($id)->delete();

        // Log out the user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the login page or home page after logout
        return redirect()->route('login'); // Or your desired post-logout redirect
    }
}
