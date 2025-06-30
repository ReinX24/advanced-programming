<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ProfileRequest extends FormRequest
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
            'name' => 'required',
            // 'email' => 'required|email|unique:users,email, ' . (($id) ? $id : null) . ',id',
            'email' => ['required', 'email', \Illuminate\Validation\Rule::unique('users')->ignore(Auth::user()->id)],
            'password' => request()->password !== null ? 'required|min:8|confirmed' : '',
            'photo' => [
                'nullable', // Photo is optional
                File::image() // Ensures it's an image
                ->max(2 * 1024) // Max 2MB (2 * 1024 KB)
                // ->dimensions(Rule::dimensions()->maxWidth(1000)->maxHeight(1000)), // Max dimensions
            ],
        ];
    }
}
