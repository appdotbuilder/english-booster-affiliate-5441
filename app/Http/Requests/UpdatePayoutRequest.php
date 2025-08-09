<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePayoutRequest extends FormRequest
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
            'amount' => 'required|numeric|min:10000',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'method' => 'required|in:bank_transfer,paypal,e_wallet,crypto',
            'payment_details' => 'nullable|array',
            'transaction_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
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
            'amount.required' => 'Payout amount is required.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.min' => 'Minimum payout amount is Rp 10,000.',
            'status.required' => 'Payout status is required.',
            'status.in' => 'Invalid payout status selected.',
            'method.required' => 'Payment method is required.',
            'method.in' => 'Invalid payment method selected.',
        ];
    }
}