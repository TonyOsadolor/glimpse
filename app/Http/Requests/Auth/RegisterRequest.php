<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'numeric', 'unique:users,phone', 'digits:11'],
            'dob' => ['nullable', 'date'],
            'gender' => ['nullable', 'numeric', 'in:Female,Male'],
            'role' => ['required', 'in:company,participant'],
            'company_name' => ['required_if:role,company'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * Get the error Messages for the defined Validation Rules
     * 
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'Please provide an :attribute address',

            'last_name.required' => 'Please provide an :attribute address',

            'email.required' => 'Invalid :attribute provided',
            'email.email' => 'Invalid :attribute provided',

            'phone.numeric' => 'Invalid :attribute provided',
            'phone.unique' => ':attribute already registered to another user',

            'gender.in' => 'Invalid :attribute provided',

            'role.required' => ':attribute is required',
            'role.in' => 'Invalid :attribute provided',

            'company_name.required_if' => ':attribute is required when Role is Company',

            'password.required' => ':attribute is required',
        ];
    }
}
