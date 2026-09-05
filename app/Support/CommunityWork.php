<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use RuntimeException;
use Symfony\Component\Finder\SplFileInfo;

class CommunityWork
{
    /**
     * @return list<string>
     */
    public static function themes(): array
    {
        return ['DISASTER', 'HEALTH', 'EDUCATION', 'LIVELIHOOD', 'COMMUNITY', 'SPORTS'];
    }

    /**
     * @return list<string>
     */
    public static function retiredSlugs(): array
    {
        return ['sarana-housing-2026', 'diyawara-water-project', 'pahana-scholarship-fund'];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function projects(): array
    {
        $projects = [];

        foreach (File::files(database_path('data/projects')) as $file) {
            if (! $file instanceof SplFileInfo || $file->getExtension() !== 'json') {
                continue;
            }

            $projects[] = self::decodeFile($file->getPathname());
        }

        usort($projects, function (array $left, array $right): int {
            return strcmp((string) ($right['completed_at'] ?? ''), (string) ($left['completed_at'] ?? ''));
        });

        return array_map(self::sanitizeRow(...), array_map(self::mergeSplitBodies(...), $projects));
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function meetings(): array
    {
        $noteEn = 'Hosted at a member home. Tea after the formal meeting.';
        $noteSi = 'සාමාජිකයෙකුගේ නිවසේදී. රැස්වීමෙන් පසු තේ.';
        $noteTa = 'ஒரு உறுப்பினர் இல்லத்தில். கூட்டத்திற்குப் பின் தேநீர்.';

        return [
            [
                'held_at' => '2026-06-14 16:00:00',
                'host_name' => 'Kamal Perera',
                'host_address' => '42 Mahulpotha, Bandarawela',
                'is_published' => true,
                'title_en' => 'Monthly member meeting — June 2026',
                'title_si' => 'මාසික සාමාජික රැස්වීම — 2026 ජූනි',
                'title_ta' => 'மாதாந்த உறுப்பினர் கூட்டம் — ஜூன் 2026',
                'notes_en' => $noteEn,
                'notes_si' => $noteSi,
                'notes_ta' => $noteTa,
            ],
            [
                'held_at' => '2026-07-12 16:00:00',
                'host_name' => 'Sanduni Fernando',
                'host_address' => '20 Mahulpotha Road, Bandarawela',
                'is_published' => true,
                'title_en' => 'Monthly member meeting — July 2026',
                'title_si' => 'මාසික සාමාජික රැස්වීම — 2026 ජූලි',
                'title_ta' => 'மாதாந்த உறுப்பினர் கூட்டம் — ஜூலை 2026',
                'notes_en' => $noteEn,
                'notes_si' => $noteSi,
                'notes_ta' => $noteTa,
            ],
            [
                'held_at' => '2026-08-09 16:00:00',
                'host_name' => 'H.M.C.P.K. Herath',
                'host_address' => 'No. 272, Kirimadugoda, Bandarawela',
                'is_published' => true,
                'title_en' => 'Monthly member meeting — August 2026',
                'title_si' => 'මාසික සාමාජික රැස්වීම — 2026 අගෝස්තු',
                'title_ta' => 'மாதாந்த உறுப்பினர் கூட்டம் — ஆகஸ்ட் 2026',
                'notes_en' => $noteEn,
                'notes_si' => $noteSi,
                'notes_ta' => $noteTa,
            ],
            [
                'held_at' => '2026-09-13 16:00:00',
                'host_name' => 'A.M. Ajith Rupasinghe',
                'host_address' => '8/2 Helahinna, Bandarawela',
                'is_published' => true,
                'title_en' => 'Monthly member meeting — September 2026',
                'title_si' => 'මාසික සාමාජික රැස්වීම — 2026 සැප්තැම්බර්',
                'title_ta' => 'மாதாந்த உறுப்பினர் கூட்டம் — செப்டம்பர் 2026',
                'notes_en' => 'Hosted at a member home. Please arrive by 3.45 p.m.',
                'notes_si' => 'සාමාජිකයෙකුගේ නිවසේදී. ප.ව. 3.45ට පැමිණෙන්න.',
                'notes_ta' => 'ஒரு உறுப்பினர் இல்லத்தில். பி.ப. 3.45க்கு வரவும்.',
            ],
            [
                'held_at' => '2026-10-11 16:00:00',
                'host_name' => 'M.S. Jayantha',
                'host_address' => 'No. 27, Galapitagedara, Bulathwela',
                'is_published' => true,
                'title_en' => 'Monthly member meeting — October 2026',
                'title_si' => 'මාසික සාමාජික රැස්වීම — 2026 ඔක්තෝබර්',
                'title_ta' => 'மாதாந்த உறுப்பினர் கூட்டம் — அக்டோபர் 2026',
                'notes_en' => $noteEn,
                'notes_si' => $noteSi,
                'notes_ta' => $noteTa,
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function decodeFile(string $path): array
    {
        $decoded = json_decode((string) File::get($path), true);

        if (! is_array($decoded) || ! isset($decoded['slug'])) {
            throw new RuntimeException('Community work file is invalid: '.basename($path).' ('.json_last_error_msg().').');
        }

        return $decoded;
    }

    /**
     * @param  array<string, mixed>  $row
     * @return array<string, mixed>
     */
    private static function mergeSplitBodies(array $row): array
    {
        foreach (['en', 'si', 'ta'] as $locale) {
            $parts = [];

            foreach (['body_'.$locale, 'body_'.$locale.'_2', 'body_'.$locale.'_3'] as $key) {
                if (isset($row[$key]) && is_string($row[$key]) && trim($row[$key]) !== '') {
                    $parts[] = trim($row[$key]);
                }

                unset($row[$key]);
            }

            if ($parts !== []) {
                $row['body_'.$locale] = implode("\n\n", $parts);
            }
        }

        return $row;
    }

    /**
     * @param  array<string, mixed>  $row
     * @return array<string, mixed>
     */
    private static function sanitizeRow(array $row): array
    {
        foreach (['si', 'ta'] as $locale) {
            $bodyKey = 'body_'.$locale;
            $summaryKey = 'summary_'.$locale;

            if (! isset($row[$bodyKey], $row[$summaryKey]) || ! is_string($row[$bodyKey]) || ! is_string($row[$summaryKey])) {
                continue;
            }

            if (str_contains($row[$bodyKey], "\u{FFFD}") || str_contains($row[$bodyKey], 'success.')) {
                $row[$bodyKey] = $row[$summaryKey];
            }
        }

        foreach ($row as $key => $value) {
            if (is_string($value)) {
                $row[$key] = str_replace("\u{FFFD}", '', $value);
            }
        }

        return $row;
    }
}
