<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSuggestionRequest extends FormRequest
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
            'category' => ['required', 'in:SUGGESTION,IDEA,GRIEVANCE'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:4000'],
            'is_anonymous' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_anonymous' => $this->boolean('is_anonymous')]);
    }
}
