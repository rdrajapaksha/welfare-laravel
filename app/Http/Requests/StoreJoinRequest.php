<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJoinRequest extends FormRequest
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
            'full_name' => ['required', 'string', 'max:255'],
            'nic' => ['required', 'string', 'max:20', Rule::unique('membership_applications', 'nic')],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'in:MALE,FEMALE,OTHER'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'address_line1' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'district' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'membership_type' => ['required', 'in:ORDINARY,JUNIOR'],
            'referred_by' => ['nullable', 'string', 'max:255'],
            'motivation' => ['nullable', 'string', 'max:2000'],
            'consent' => ['accepted'],
        ];
    }
}
