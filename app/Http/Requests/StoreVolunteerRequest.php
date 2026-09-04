<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVolunteerRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'nic' => ['nullable', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:120'],
            'district' => ['required', 'string', 'max:120'],
            'date_of_birth' => ['nullable', 'date'],
            'interests' => ['required', 'array', 'min:1'],
            'interests.*' => ['string', 'max:50'],
            'skills' => ['nullable', 'string', 'max:1000'],
            'availability' => ['required', 'in:WEEKENDS,WEEKDAYS,EVENINGS,FLEXIBLE'],
            'hours_per_month' => ['required', 'integer', 'min:4', 'max:80'],
            'experience' => ['nullable', 'string', 'max:2000'],
            'motivation' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
