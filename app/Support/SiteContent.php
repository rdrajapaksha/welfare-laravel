<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Arr;

class SiteContent
{
    /**
     * @return array<string, mixed>
     */
    public static function identity(): array
    {
        return once(function (): array {
            $site = config('hla');
            $rows = SiteSetting::query()->where('group', 'identity')->get()->keyBy('key');

            foreach (['name', 'short_name', 'registration_no'] as $key) {
                $value = self::rowValue($rows->get($key));
                if ($value !== null) {
                    $site[$key] = $value;
                }
            }

            foreach ([
                'phone', 'phone_display', 'hotline', 'hotline_display', 'email',
                'street', 'locality', 'region', 'postal_code', 'map_embed', 'map_link',
            ] as $key) {
                $value = self::rowValue($rows->get($key));
                if ($value !== null) {
                    $site['contact'][$key] = $value;
                }
            }

            foreach ([
                'bank_name' => 'bank_name',
                'branch' => 'bank_branch',
                'account_name' => 'bank_account_name',
                'account_no' => 'bank_account_no',
                'swift' => 'bank_swift',
            ] as $bankKey => $settingKey) {
                $value = self::rowValue($rows->get($settingKey));
                if ($value !== null) {
                    $site['bank'][$bankKey] = $value;
                }
            }

            return $site;
        });
    }

    public static function vision(): string
    {
        return self::translated('about_vision', AboutContent::vision());
    }

    public static function mission(): string
    {
        return self::translated('about_mission', AboutContent::mission());
    }

    public static function intro(): string
    {
        return self::translated('about_intro', AboutContent::intro());
    }

    /**
     * @return list<string>
     */
    public static function introParagraphs(): array
    {
        return self::lines(self::intro(), '/\n\s*\n/');
    }

    /**
     * @return list<string>
     */
    public static function objectives(): array
    {
        return self::lines(self::translated('about_objectives', AboutContent::objectivesText()));
    }

    /**
     * @return array<string, string>
     */
    public static function aboutForm(): array
    {
        $vision = AboutContent::vision();
        $mission = AboutContent::mission();
        $intro = AboutContent::intro();
        $objectives = AboutContent::objectivesText();

        return [
            'vision_en' => self::raw('about_vision', 'en', $vision['en']),
            'vision_si' => self::raw('about_vision', 'si', $vision['si']),
            'vision_ta' => self::raw('about_vision', 'ta', $vision['ta']),
            'mission_en' => self::raw('about_mission', 'en', $mission['en']),
            'mission_si' => self::raw('about_mission', 'si', $mission['si']),
            'mission_ta' => self::raw('about_mission', 'ta', $mission['ta']),
            'intro_en' => self::raw('about_intro', 'en', $intro['en']),
            'intro_si' => self::raw('about_intro', 'si', $intro['si']),
            'intro_ta' => self::raw('about_intro', 'ta', $intro['ta']),
            'objectives_en' => self::raw('about_objectives', 'en', $objectives['en']),
            'objectives_si' => self::raw('about_objectives', 'si', $objectives['si']),
            'objectives_ta' => self::raw('about_objectives', 'ta', $objectives['ta']),
        ];
    }

    public static function copy(string $key): string
    {
        return self::translated($key, self::dictionaryTriple($key));
    }

    /**
     * @return array<string, string>
     */
    public static function homeForm(): array
    {
        return self::localizedForm(self::homeFields());
    }

    /**
     * @return array<string, string>
     */
    public static function legalForm(): array
    {
        return self::localizedForm(self::legalFields());
    }

    /**
     * @return array<string, string>
     */
    public static function homeFields(): array
    {
        return [
            'hero_eyebrow' => 'home.heroEyebrow',
            'hero_title' => 'home.heroTitle',
            'hero_accent' => 'home.heroTitleAccent',
            'hero_subtitle' => 'home.heroSubtitle',
            'cta_title' => 'home.ctaTitle',
            'cta_text' => 'home.ctaText',
            'footer_about' => 'footer.aboutText',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function legalFields(): array
    {
        return [
            'privacy' => 'legal.privacy',
            'terms' => 'legal.terms',
        ];
    }

    /**
     * @param  array{en: string, si: string, ta: string}  $values
     */
    public static function saveLocalized(string $key, string $group, array $values): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => $key],
            [
                'value_en' => $values['en'],
                'value_si' => $values['si'],
                'value_ta' => $values['ta'],
                'group' => $group,
            ],
        );
    }

    public static function saveIdentityValue(string $key, string $value): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => $key],
            [
                'value_en' => $value,
                'value_si' => $value,
                'value_ta' => $value,
                'group' => 'identity',
            ],
        );
    }

    /**
     * @param  array<string, string>  $fields
     * @return array<string, string>
     */
    private static function localizedForm(array $fields): array
    {
        $form = [];

        foreach ($fields as $field => $key) {
            $fallback = self::dictionaryTriple($key);

            foreach (['en', 'si', 'ta'] as $locale) {
                $form[$field.'_'.$locale] = self::raw($key, $locale, $fallback[$locale]);
            }
        }

        return $form;
    }

    /**
     * @return array{en: string, si: string, ta: string}
     */
    private static function dictionaryTriple(string $key): array
    {
        $hardcoded = self::hardcodedCopy($key);

        return [
            'en' => self::dictionaryValue('en', $key) ?: $hardcoded['en'],
            'si' => self::dictionaryValue('si', $key) ?: $hardcoded['si'],
            'ta' => self::dictionaryValue('ta', $key) ?: $hardcoded['ta'],
        ];
    }

    private static function dictionaryValue(string $locale, string $key): string
    {
        $value = Arr::get(Dictionary::all($locale), $key);

        return is_string($value) ? $value : '';
    }

    /**
     * @return array{en: string, si: string, ta: string}
     */
    private static function hardcodedCopy(string $key): array
    {
        return match ($key) {
            'legal.privacy' => [
                'en' => 'Heart Link Allianze Welfare Society stores membership and donation records only for association administration, welfare claims and statutory reporting. We do not sell personal data.',
                'si' => 'Heart Link Allianze Welfare Society stores membership and donation records only for association administration, welfare claims and statutory reporting. We do not sell personal data.',
                'ta' => 'Heart Link Allianze Welfare Society stores membership and donation records only for association administration, welfare claims and statutory reporting. We do not sell personal data.',
            ],
            'legal.terms' => [
                'en' => 'Use of this website is subject to the constitution of the association. Membership is granted only after committee admission. Donations are voluntary and receipted once confirmed.',
                'si' => 'Use of this website is subject to the constitution of the association. Membership is granted only after committee admission. Donations are voluntary and receipted once confirmed.',
                'ta' => 'Use of this website is subject to the constitution of the association. Membership is granted only after committee admission. Donations are voluntary and receipted once confirmed.',
            ],
            default => ['en' => '', 'si' => '', 'ta' => ''],
        };
    }

    /**
     * @param  array{en: string, si: string, ta: string}  $fallback
     */
    private static function translated(string $key, array $fallback): string
    {
        $row = SiteSetting::query()->where('key', $key)->first();

        if ($row instanceof SiteSetting) {
            $value = $row->translate('value');

            if ($value !== '') {
                return $value;
            }
        }

        return AboutContent::pick($fallback);
    }

    private static function raw(string $key, string $locale, string $fallback): string
    {
        $column = 'value_'.$locale;
        $stored = SiteSetting::query()->where('key', $key)->value($column);

        return is_string($stored) && trim($stored) !== '' ? $stored : $fallback;
    }

    /**
     * @return list<string>
     */
    private static function lines(string $text, string $pattern = '/\r\n|\r|\n/'): array
    {
        $parts = preg_split($pattern, trim($text)) ?: [];

        return array_values(array_filter(array_map('trim', $parts), fn (string $line): bool => $line !== ''));
    }

    private static function rowValue(mixed $row): ?string
    {
        if (! $row instanceof SiteSetting) {
            return null;
        }

        $value = $row->translate('value');

        return $value !== '' ? $value : null;
    }
}
