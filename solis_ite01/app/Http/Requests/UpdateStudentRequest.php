<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $student = $this->route("student");

        return [
            'fname' => 'required|string|max:128',
            'lname' => 'required|string|max:128',
            'email' => ['required', 'email', 'max:128', \Illuminate\Validation\Rule::unique('students')->ignore($student->id)],
            'contact_number' => 'nullable|string|max:50',
            'gender' => 'nullable|in:Male,Female',
            'birthdate' => 'nullable|date|before_or_equal:today',
            'complete_address' => 'nullable|string',
            'bio' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'fname.required' => 'First name is required.',
            'lname.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'This email is already taken.'
        ];
    }
}
