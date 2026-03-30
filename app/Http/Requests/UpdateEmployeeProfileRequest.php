<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user()->id;

        $rules = [
            'employee_name' => ['required', 'string', 'max:255'],
            'center' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
        ];

        if ($this->passwordChangeRequested()) {
            $rules['current_password'] = ['required', 'string', 'current_password'];
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        return $rules;
    }

    public function passwordChangeRequested(): bool
    {
        return filled($this->input('current_password'))
            || filled($this->input('password'))
            || filled($this->input('password_confirmation'));
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'employee_name.required' => 'Full name is required.',
            'center.required' => 'Center or office is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email is already in use.',
            'current_password.required' => 'Current password is required to change your password.',
            'current_password.current_password' => 'The current password is incorrect.',
            'password.required' => 'New password is required when changing password.',
            'password.min' => 'New password must be at least 8 characters.',
            'password.confirmed' => 'New password confirmation does not match.',
        ];
    }
}
