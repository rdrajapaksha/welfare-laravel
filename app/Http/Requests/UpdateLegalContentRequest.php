<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLegalContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'privacy_en' => ['required', 'string', 'max:8000'],
            'privacy_si' => ['required', 'string', 'max:8000'],
            'privacy_ta' => ['required', 'string', 'max:8000'],
            'terms_en' => ['required', 'string', 'max:8000'],
            'terms_si' => ['required', 'string', 'max:8000'],
            'terms_ta' => ['required', 'string', 'max:8000'],
        ];
    }
}
