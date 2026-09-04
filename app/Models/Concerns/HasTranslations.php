<?php

namespace App\Models\Concerns;

trait HasTranslations
{
    /**
     * Read a translated column such as title_en / title_si / title_ta.
     */
    public function translate(string $attribute): string
    {
        $suffix = match (app()->getLocale()) {
            'si' => '_si',
            'ta' => '_ta',
            default => '_en',
        };

        $value = $this->getAttribute($attribute.$suffix);

        if (is_string($value) && trim($value) !== '') {
            return $value;
        }

        return (string) ($this->getAttribute($attribute.'_en') ?? '');
    }
}
