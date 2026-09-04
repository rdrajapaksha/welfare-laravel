<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutContentRequest extends FormRequest
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
            'vision_en' => ['required', 'string', 'max:2000'],
            'vision_si' => ['required', 'string', 'max:2000'],
            'vision_ta' => ['required', 'string', 'max:2000'],
            'mission_en' => ['required', 'string', 'max:4000'],
            'mission_si' => ['required', 'string', 'max:4000'],
            'mission_ta' => ['required', 'string', 'max:4000'],
            'intro_en' => ['required', 'string', 'max:8000'],
            'intro_si' => ['required', 'string', 'max:8000'],
            'intro_ta' => ['required', 'string', 'max:8000'],
            'objectives_en' => ['required', 'string', 'max:8000'],
            'objectives_si' => ['required', 'string', 'max:8000'],
            'objectives_ta' => ['required', 'string', 'max:8000'],
        ];
    }
}
