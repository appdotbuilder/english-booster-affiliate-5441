<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePayoutRequest extends FormRequest
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
            'affiliate_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:10000', // Minimum 10,000 IDR
            'method' => 'required|in:bank_transfer,paypal,e_wallet,crypto',
            'payment_details' => 'nullable|array',
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
            'affiliate_id.required' => 'Affiliate is required.',
            'affiliate_id.exists' => 'Selected affiliate does not exist.',
            'amount.required' => 'Payout amount is required.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.min' => 'Minimum payout amount is Rp 10,000.',
            'method.required' => 'Payment method is required.',
            'method.in' => 'Invalid payment method selected.',
        ];
    }
}