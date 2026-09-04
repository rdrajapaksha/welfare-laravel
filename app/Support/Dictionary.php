<?php

namespace App\Support;

use Illuminate\Support\Arr;

class Dictionary
{
    /**
     * @var array<string, array<string, mixed>>
     */
    private static array $loaded = [];

    /**
     * @return array<string, mixed>
     */
    public static function all(?string $locale = null): array
    {
        $locale ??= app()->getLocale();

        if (! isset(self::$loaded[$locale])) {
            $path = resource_path('dictionaries/'.$locale.'.json');

            if (! is_file($path)) {
                $path = resource_path('dictionaries/en.json');
            }

            /** @var array<string, mixed> $decoded */
            $decoded = json_decode((string) file_get_contents($path), true) ?: [];
            self::$loaded[$locale] = $decoded;
        }

        return self::$loaded[$locale];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return Arr::get(self::all(), $key, $default);
    }
}
