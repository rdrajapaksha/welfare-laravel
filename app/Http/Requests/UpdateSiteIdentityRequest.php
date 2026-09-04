<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteIdentityRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'short_name' => ['required', 'string', 'max:120'],
            'registration_no' => ['required', 'string', 'max:80'],
            'street' => ['required', 'string', 'max:255'],
            'locality' => ['required', 'string', 'max:120'],
            'region' => ['required', 'string', 'max:120'],
            'postal_code' => ['required', 'string', 'max:20'],
            'phone_display' => ['required', 'string', 'max:40'],
            'hotline_display' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', 'max:255'],
        ];
    }
}
