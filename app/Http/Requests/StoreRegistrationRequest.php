<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'age' => 'nullable|integer|min:5|max:100',
            'motivation' => 'nullable|string|max:1000',
            'learning_goals' => 'nullable|string|max:1000',
            'previous_experience' => 'nullable|string|max:1000',
            'referral_code' => 'nullable|string|exists:users,referral_code',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Full name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'phone.max' => 'Phone number is too long.',
            'age.integer' => 'Age must be a number.',
            'age.min' => 'Age must be at least 5 years.',
            'age.max' => 'Age cannot exceed 100 years.',
            'referral_code.exists' => 'Invalid referral code.',
        ];
    }
}