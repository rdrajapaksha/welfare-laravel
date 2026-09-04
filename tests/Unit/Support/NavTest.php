<?php

namespace Tests\Unit\Support;

use App\Support\Dictionary;
use App\Support\Nav;
use Tests\TestCase;

class NavTest extends TestCase
{
    public function test_main_nav_keeps_committee_and_advisory_under_about(): void
    {
        $aboutHrefs = $this->childHrefs('/about');

        $this->assertContains('/about/committee', $aboutHrefs);
        $this->assertContains('/about/advisory', $aboutHrefs);
    }

    public function test_main_nav_does_not_repeat_child_links(): void
    {
        $hrefs = [];

        foreach (Nav::main(Dictionary::all('en')) as $item) {
            foreach ($item['children'] ?? [] as $child) {
                $hrefs[] = $child['href'];
            }
        }

        $duplicates = array_keys(array_filter(
            array_count_values($hrefs),
            fn (int $count): bool => $count > 1,
        ));

        $this->assertSame([], $duplicates);
    }

    public function test_contact_menu_does_not_repeat_the_contact_page(): void
    {
        $this->assertNotContains('/contact', $this->childHrefs('/contact'));
    }

    /**
     * @return list<string>
     */
    private function childHrefs(string $parentHref): array
    {
        foreach (Nav::main(Dictionary::all('en')) as $item) {
            if ($item['href'] === $parentHref) {
                return array_column($item['children'] ?? [], 'href');
            }
        }

        return [];
    }
}
