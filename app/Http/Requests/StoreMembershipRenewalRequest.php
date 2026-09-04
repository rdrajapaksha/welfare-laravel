<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMembershipRenewalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->member !== null;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'months' => ['required', 'array', 'min:1'],
            'months.*' => ['required', 'string', 'regex:/^\d{4}-\d{2}$/'],
            'method' => ['required', 'in:BANK_TRANSFER,CASH,CHEQUE'],
        ];
    }
}
