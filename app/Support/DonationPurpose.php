<?php

namespace App\Support;

use App\Models\Project;
use Illuminate\Support\Collection;

class DonationPurpose
{
    /**
     * @return array<string, string>
     */
    public static function funds(): array
    {
        return [
            'GENERAL' => (string) d('donations.purposeGeneral'),
            'EMERGENCY' => (string) d('donations.purposeEmergency'),
            'EDUCATION' => (string) d('donations.purposeEducation'),
            'MEDICAL' => (string) d('donations.purposeMedical'),
        ];
    }

    public static function label(string $purpose, ?Project $project = null): string
    {
        if ($project !== null) {
            $title = $project->translate('title');

            if ($title !== '') {
                return $title;
            }
        }

        return match ($purpose) {
            'EMERGENCY' => (string) d('donations.purposeEmergency'),
            'EDUCATION' => (string) d('donations.purposeEducation'),
            'MEDICAL' => (string) d('donations.purposeMedical'),
            'PROJECT' => (string) d('donations.purposeProject'),
            default => (string) d('donations.purposeGeneral'),
        };
    }

    /**
     * @return array{purpose: string, project_id: int|null}
     */
    public static function fromDestination(string $destination): array
    {
        if (str_starts_with($destination, 'project:')) {
            $projectId = (int) substr($destination, 8);

            return [
                'purpose' => 'PROJECT',
                'project_id' => $projectId > 0 ? $projectId : null,
            ];
        }

        return [
            'purpose' => $destination !== '' ? $destination : 'GENERAL',
            'project_id' => null,
        ];
    }

    /**
     * @param  Collection<int, Project>  $projects
     */
    public static function selectedDestination(string $projectSlug, Collection $projects): string
    {
        $old = old('destination');

        if (is_string($old) && $old !== '') {
            return $old;
        }

        if ($projectSlug !== '') {
            $project = $projects->firstWhere('slug', $projectSlug);

            if ($project instanceof Project) {
                return 'project:'.$project->id;
            }
        }

        return 'GENERAL';
    }
}
