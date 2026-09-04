<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PhotoStore
{
    /**
     * @return list<string>
     */
    public static function imageRules(bool $required = false): array
    {
        return [$required ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'];
    }

    /**
     * @return list<string>
     */
    public static function pdfRules(bool $required = false): array
    {
        return [$required ? 'required' : 'nullable', 'file', 'mimes:pdf', 'max:10240'];
    }

    public static function kilobytes(?UploadedFile $file): int
    {
        if ($file === null) {
            return 0;
        }

        return (int) ceil($file->getSize() / 1024);
    }

    public static function store(?UploadedFile $file, string $directory, ?string $current = null): ?string
    {
        if ($file === null) {
            return $current;
        }

        $path = $file->store($directory, 'public');

        if (is_string($current) && $current !== '' && ! str_starts_with($current, '/') && Storage::disk('public')->exists($current)) {
            Storage::disk('public')->delete($current);
        }

        return $path ?: $current;
    }

    public static function url(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    public static function delete(?string $path): void
    {
        if ($path === null || $path === '' || str_starts_with($path, '/') || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public static function initials(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name)) ?: [];
        $letters = '';

        foreach ($parts as $part) {
            if ($part === '') {
                continue;
            }

            $letters .= mb_strtoupper(mb_substr($part, 0, 1));

            if (mb_strlen($letters) >= 2) {
                break;
            }
        }

        return $letters !== '' ? $letters : '?';
    }
}
