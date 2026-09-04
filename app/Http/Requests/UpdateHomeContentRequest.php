<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeContentRequest extends FormRequest
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
            'hero_eyebrow_en' => ['required', 'string', 'max:120'],
            'hero_eyebrow_si' => ['required', 'string', 'max:120'],
            'hero_eyebrow_ta' => ['required', 'string', 'max:120'],
            'hero_title_en' => ['required', 'string', 'max:120'],
            'hero_title_si' => ['required', 'string', 'max:120'],
            'hero_title_ta' => ['required', 'string', 'max:120'],
            'hero_accent_en' => ['required', 'string', 'max:120'],
            'hero_accent_si' => ['required', 'string', 'max:120'],
            'hero_accent_ta' => ['required', 'string', 'max:120'],
            'hero_subtitle_en' => ['required', 'string', 'max:2000'],
            'hero_subtitle_si' => ['required', 'string', 'max:2000'],
            'hero_subtitle_ta' => ['required', 'string', 'max:2000'],
            'cta_title_en' => ['required', 'string', 'max:255'],
            'cta_title_si' => ['required', 'string', 'max:255'],
            'cta_title_ta' => ['required', 'string', 'max:255'],
            'cta_text_en' => ['required', 'string', 'max:2000'],
            'cta_text_si' => ['required', 'string', 'max:2000'],
            'cta_text_ta' => ['required', 'string', 'max:2000'],
            'footer_about_en' => ['required', 'string', 'max:2000'],
            'footer_about_si' => ['required', 'string', 'max:2000'],
            'footer_about_ta' => ['required', 'string', 'max:2000'],
        ];
    }
}
