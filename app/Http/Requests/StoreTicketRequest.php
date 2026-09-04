<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
        return [
            'category' => ['required', 'in:WELFARE_CLAIM,PAYMENT,PROFILE,GRIEVANCE,EVENT,TECHNICAL,OTHER'],
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:4000'],
            'priority' => ['required', 'in:LOW,MEDIUM,HIGH,URGENT'],
        ];
    }
}
