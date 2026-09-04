<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'donor_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'amount' => ['required', 'integer', 'min:100'],
            'method' => ['required', 'in:BANK_TRANSFER,CASH,CHEQUE'],
            'purpose' => ['required', 'in:GENERAL,EMERGENCY,EDUCATION,MEDICAL,PROJECT'],
            'message' => ['nullable', 'string', 'max:1000'],
            'is_anonymous' => ['sometimes', 'boolean'],
            'is_recurring' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_anonymous' => $this->boolean('is_anonymous'),
            'is_recurring' => $this->boolean('is_recurring'),
        ]);
    }
}
