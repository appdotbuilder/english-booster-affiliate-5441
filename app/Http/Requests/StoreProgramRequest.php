<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
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
            'description' => 'nullable|string',
            'type' => 'required|in:online,offline,rombongan,cabang',
            'duration' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'image_url' => 'nullable|url',
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
            'name.required' => 'Program name is required.',
            'type.required' => 'Program type is required.',
            'type.in' => 'Invalid program type selected.',
            'duration.required' => 'Program duration is required.',
            'price.required' => 'Program price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price cannot be negative.',
            'commission_rate.numeric' => 'Commission rate must be a number.',
            'commission_rate.min' => 'Commission rate cannot be negative.',
            'commission_rate.max' => 'Commission rate cannot exceed 100%.',
            'features.array' => 'Features must be a list.',
            'image_url.url' => 'Image URL must be a valid URL.',
        ];
    }
}