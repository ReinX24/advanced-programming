<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Mail\AppointmentCreated;
use App\Models\Appointment;
use App\Models\Student;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with('student')->latest()->paginate(10);

        return view('client.appointments.index', [
            'appointments' => $appointments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::orderBy('lname')->get();

        return view('client.appointments.create', [
            'students' => $students
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request)
    {
        $validatedData = $request->validated();

        $student = Student::findOrFail($validatedData["student_id"]);

        $appointment = Appointment::create([
            'student_id' => $student->id,
            'title' => $validatedData["title"],
            'appointment_date' => $validatedData["appointment_date"],
            'appointment_time' => $validatedData["appointment_time"],
            'remarks' => $validatedData["remarks"],
            'status' => 'Pending'
        ]);

        if ($student->email) {
            Mail::to($student->email)->send(new AppointmentCreated($appointment));
        }

        return redirect()->route('appointments.show', $appointment)->with('success', 'Appointment added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return view('client.appointments.show', ['appointment' => $appointment]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $students = Student::orderBy('lname')->get();
        return view('client.appointments.edit', ['appointment' => $appointment, 'students' => $students]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        $validatedData = $request->validated();

        $appointment->update($validatedData);

        return redirect()->route('appointments.show', $appointment)->with('success', 'Appointment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully!');
    }

    public function toggleStatus(Appointment $appointment)
    {
        if ($appointment->status === "Pending") {
            $appointment->status = "Completed";
        } else {
            $appointment->status = "Pending";
        }

        $appointment->save();

        return redirect()->route('appointments.show', $appointment)->with('success', 'Marked appointment as ' . $appointment->status);
    }
}
