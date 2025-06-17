<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Models\User;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["students"] = Student::latest()->paginate(10);
        $data["isAdmin"] = true;
        $data["user"] = User::findOrFail(1)->first();

        return view('students.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("students.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $validatedData = $request->validated();

        $student = Student::create($validatedData);

        // Redirect back with a success message (or to another route)
        return redirect()->route("students.show", $student)->with('success', 'Student added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', ["student" => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', ["student" => $student]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $validatedData = $request->validated();

        $student->update($validatedData);

        return redirect()->route('students.show', $student->id)->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}
