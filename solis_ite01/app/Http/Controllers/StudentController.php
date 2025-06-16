<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $data["students"] = Student::latest()->paginate(10);
        $data["isAdmin"] = true;
        $data["user"] = "Rein Solis";

        return view('students.index', $data);
    }

    public function create()
    {
        return view("students.create");
    }

    public function show(Student $student)
    {
        return view('students.show', ["student" => $student]);
    }

    public function edit(Student $student)
    {
        return view('students.edit', ["student" => $student]);
    }

    public function store(Request $request)
    {
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
        $student = Student::create($validatedData);

        // Redirect back with a success message (or to another route)
        return redirect()->route("students.show", $student)->with('success', 'Student added successfully!');
    }

    public function update(Request $request, Student $student)
    {
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
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}
