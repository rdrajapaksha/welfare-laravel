<?php

namespace App\Http\Requests;

use App\Enums\CommitteeBoard;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommitteeMemberRequest extends FormRequest
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
            'board' => ['required', Rule::enum(CommitteeBoard::class)],
            'name' => ['required', 'string', 'max:255'],
            'position_en' => ['required', 'string', 'max:255'],
            'position_si' => ['nullable', 'string', 'max:255'],
            'position_ta' => ['nullable', 'string', 'max:255'],
            'bio_en' => ['nullable', 'string', 'max:2000'],
            'bio_si' => ['nullable', 'string', 'max:2000'],
            'bio_ta' => ['nullable', 'string', 'max:2000'],
            'phone' => ['nullable', 'string', 'max:40'],
            'term_from' => ['required', 'integer', 'min:2000', 'max:2100'],
            'term_to' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'is_current' => ['sometimes', 'boolean'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'position_si' => (string) $this->input('position_si', ''),
            'position_ta' => (string) $this->input('position_ta', ''),
        ]);
    }
}
