<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = request()->input('id');

        if ($id) {
            $user = User::findOrFail($id);
            return [
                'name' => 'required',
                'email' => ['required', 'email', \Illuminate\Validation\Rule::unique('students')->ignore($user->id)],
                'password' => 'required|min:6'
            ];
        } else {
            return [
                'name' => 'required',
                // 'email' => 'required|email|unique:users,email, ' . (($id) ? $id : null) . ',id',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:6'
            ];
        }
    }
}
