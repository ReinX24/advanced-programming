<?php

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

Route::get('/profile', function () {
    $greetings = 'Rein Solis';
    return view('profile', [
        'greetings' => $greetings
    ]);
});

Route::get('/students', function () {
    $data["students"] = Student::latest()->paginate(10);

    $data["isAdmin"] = true;

    $data["user"] = "Rein Solis";

    return view('students.index', $data);
})->name('students.index');

Route::get('/students/create', function () {
    return view("students.create");
})->name("students.add");

Route::get('students/{student}/edit', function (Student $student) {
    return view('students.edit', ["student" => $student]);
})->name("students.edit");

Route::get('/students/{student}', function (Student $student) {
    return view('students.show', ["student" => $student]);
})->name("students.show");

Route::post('/students', function (Request $request) {
    $validatedData = $request->validate([
        'fname' => 'required|string|max:128',
        'lname' => 'required|string|max:128',
        'email' => 'required|email|max:128|unique:students,email', // Added email validation and uniqueness
        'contact_number' => 'nullable|string|max:50', // Based on your migration, this is nullable
        'gender' => 'nullable|in:Male,Female', // Based on your migration, this is nullable and an enum
        'birthdate' => 'nullable|date', // Based on your migration, this is nullable
        'complete_address' => 'nullable|string', // Based on your migration, this is nullable
        'bio' => 'nullable|string', // Based on your migration, this is nullable
    ]);

    // Create a new Student instance and fill it with the validated data
    Student::create($validatedData);

    // Redirect back with a success message (or to another route)
    return redirect()->route("students.show")->with('success', 'Student added successfully!');
})->name("students.store");

Route::patch('/students/{student}/update', function (Request $request, Student $student) {
    // Validation logic for update (similar to store, but consider unique email exception)
    $validatedData = $request->validate([
        'fname' => 'required|string|max:128',
        'lname' => 'required|string|max:128',
        // Rule::unique('students', 'email')->ignore($student->id) allows current email
        'email' => ['required', 'email', 'max:128', \Illuminate\Validation\Rule::unique('students')->ignore($student->id)],
        'contact_number' => 'nullable|string|max:50',
        'gender' => 'nullable|in:Male,Female',
        'birthdate' => 'nullable|date',
        'complete_address' => 'nullable|string',
        'bio' => 'nullable|string',
    ]);

    // Update the student record
    $student->update($validatedData);

    return redirect()->route('students.show', $student->id)->with('success', 'Student updated successfully!');
})->name("students.update");

Route::delete("/students/{student}/delete", function (Request $request, Student $student) {
    $student->delete();

    return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
})->name("students.destroy");

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
