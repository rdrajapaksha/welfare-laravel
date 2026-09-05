<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\FundAllocation;
use App\Models\MemberMeeting;
use App\Models\Project;
use App\Models\ProjectPhoto;
use App\Support\CommunityWork;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class CommunityWorkSeeder extends Seeder
{
    public function run(): void
    {
        $this->retireOldProjects();
        $this->seedProjects();
        $this->seedMeetings();
    }

    private function retireOldProjects(): void
    {
        $ids = Project::query()->whereIn('slug', CommunityWork::retiredSlugs())->pluck('id');

        if ($ids->isEmpty()) {
            return;
        }

        Donation::query()->whereIn('project_id', $ids)->update(['project_id' => null]);
        FundAllocation::query()->whereIn('project_id', $ids)->delete();
        ProjectPhoto::query()->whereIn('project_id', $ids)->delete();
        Project::query()->whereIn('id', $ids)->delete();
    }

    private function seedProjects(): void
    {
        foreach (CommunityWork::projects() as $row) {
            Project::query()->updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'title_en' => $row['title_en'],
                    'title_si' => $row['title_si'],
                    'title_ta' => $row['title_ta'],
                    'summary_en' => $row['summary_en'],
                    'summary_si' => $row['summary_si'],
                    'summary_ta' => $row['summary_ta'],
                    'body_en' => $this->paragraphs((string) $row['body_en']),
                    'body_si' => $this->paragraphs((string) $row['body_si']),
                    'body_ta' => $this->paragraphs((string) $row['body_ta']),
                    'location' => $row['location'],
                    'theme' => $row['theme'],
                    'status' => 'COMPLETED',
                    'target_amount' => 0,
                    'raised_amount' => 0,
                    'spent_amount' => (int) $row['spent_amount'],
                    'beneficiaries' => (int) $row['beneficiaries'],
                    'started_at' => $row['started_at'],
                    'completed_at' => $row['completed_at'],
                    'cover_image' => $row['cover_image'],
                ],
            );
        }
    }

    private function seedMeetings(): void
    {
        foreach (CommunityWork::meetings() as $row) {
            MemberMeeting::query()->updateOrCreate(
                [
                    'held_at' => $row['held_at'],
                    'host_name' => $row['host_name'],
                ],
                [
                    'title_en' => $row['title_en'],
                    'title_si' => $row['title_si'],
                    'title_ta' => $row['title_ta'],
                    'notes_en' => $row['notes_en'],
                    'notes_si' => $row['notes_si'],
                    'notes_ta' => $row['notes_ta'],
                    'host_address' => $row['host_address'],
                    'is_published' => (bool) ($row['is_published'] ?? true),
                ],
            );
        }
    }

    private function paragraphs(string $text): string
    {
        if (str_contains($text, '<p>')) {
            return $text;
        }

        /** @var Collection<int, string> $parts */
        $parts = Collection::make(preg_split('/\n{2,}/', trim($text)) ?: []);

        return $parts
            ->map(fn (string $paragraph): string => trim($paragraph))
            ->filter()
            ->map(fn (string $paragraph): string => '<p>'.e($paragraph).'</p>')
            ->implode('');
    }
}
