<?php

use App\Support\Dictionary;

if (! function_exists('d')) {
    /**
     * Read a nested key from the active locale dictionary.
     */
    function d(string $key, mixed $default = null): mixed
    {
        return Dictionary::get($key, $default);
    }
}

if (! function_exists('locale_url')) {
    /**
     * Build a public URL under the current (or given) locale prefix.
     *
     * @param  array<string, mixed>  $query
     */
    function locale_url(string $path = '/', array $query = [], ?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $parts = parse_url($path) ?: [];
        $normalized = '/'.ltrim($parts['path'] ?? '/', '/');
        $hash = isset($parts['fragment']) ? '#'.$parts['fragment'] : '';

        parse_str($parts['query'] ?? '', $fromPath);
        $query = array_merge($fromPath, $query);

        $url = $normalized === '/'
            ? url('/'.$locale)
            : url('/'.$locale.$normalized);

        if ($query !== []) {
            $url .= '?'.http_build_query($query);
        }

        return $url.$hash;
    }
}

if (! function_exists('lkr')) {
    /**
     * Format an integer rupee amount for display.
     */
    function lkr(int $amount): string
    {
        return 'Rs. '.number_format($amount);
    }
}

if (! function_exists('switch_locale_url')) {
    /**
     * Swap the locale segment of the current request path.
     */
    function switch_locale_url(string $locale): string
    {
        $segments = request()->segments();

        if ($segments === []) {
            return url('/'.$locale);
        }

        $segments[0] = $locale;

        $url = url('/'.implode('/', $segments));
        $query = request()->getQueryString();

        return $query ? $url.'?'.$query : $url;
    }
}
