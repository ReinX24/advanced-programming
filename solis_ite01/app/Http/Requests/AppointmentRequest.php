<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:students,id'], // Ensures student_id is present and refers to an existing student
            'title' => ['required', 'string', 'max:255'], // Title is required, a string, and max 255 characters
            'appointment_date' => ['required', 'date', 'after_or_equal:today'], // Date is required, a valid date, and not in the past
            'appointment_time' => ['required', 'date_format:H:i:s'], // Time is required and in HH:MM:SS format
            'remarks' => ['nullable', 'string'], // Remarks are optional and can be a string
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'Select valid student',
            'student_id.exists:students,id' => 'Student not found',
        ];
    }
}
