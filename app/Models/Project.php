<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'slug', 'title_en', 'title_si', 'title_ta', 'summary_en', 'summary_si', 'summary_ta',
    'body_en', 'body_si', 'body_ta', 'location', 'target_amount', 'raised_amount', 'spent_amount',
    'beneficiaries', 'status', 'theme', 'started_at', 'completed_at', 'cover_image', 'document_path',
])]
class Project extends Model
{
    public const MAX_PHOTOS = 3;

    /**
     * @var list<string>
     */
    public const THEMES = ['DISASTER', 'HEALTH', 'EDUCATION', 'LIVELIHOOD', 'COMMUNITY', 'SPORTS'];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'theme' => 'COMMUNITY',
    ];

    /** @use HasFactory<ProjectFactory> */
    use HasFactory, HasTranslations;

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'target_amount' => 'integer',
            'raised_amount' => 'integer',
            'spent_amount' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(FundAllocation::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ProjectPhoto::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * @return list<string>
     */
    public function galleryPaths(): array
    {
        $paths = $this->photos->pluck('path')->filter()->values();

        if ($paths->isEmpty() && is_string($this->cover_image) && $this->cover_image !== '') {
            return [$this->cover_image];
        }

        return $paths->take(self::MAX_PHOTOS)->all();
    }

    public function hasFundraising(): bool
    {
        return (int) $this->target_amount > 0;
    }

    public function themeLabel(): string
    {
        return (string) d('projects.themes.'.strtolower((string) $this->theme), $this->theme);
    }

    public function themeBarClass(): string
    {
        return self::themeBarClassFor((string) $this->theme);
    }

    public function themeChipClass(): string
    {
        return self::themeChipClassFor((string) $this->theme);
    }

    public static function themeBarClassFor(string $theme): string
    {
        return match (strtoupper($theme)) {
            'DISASTER' => 'bg-brand-600',
            'HEALTH' => 'bg-teal-600',
            'EDUCATION' => 'bg-gold-500',
            'LIVELIHOOD' => 'bg-gold-700',
            'SPORTS' => 'bg-teal-800',
            default => 'bg-ink-700',
        };
    }

    public static function themeChipClassFor(string $theme): string
    {
        return match (strtoupper($theme)) {
            'DISASTER' => 'bg-brand-50 text-brand-800 ring-brand-100',
            'HEALTH' => 'bg-teal-50 text-teal-800 ring-teal-100',
            'EDUCATION' => 'bg-gold-50 text-gold-800 ring-gold-100',
            'LIVELIHOOD' => 'bg-gold-50 text-gold-800 ring-gold-100',
            'SPORTS' => 'bg-teal-50 text-teal-800 ring-teal-100',
            default => 'bg-ink-50 text-ink-700 ring-ink-100',
        };
    }

    #[Scope]
    protected function ongoing(Builder $query): Builder
    {
        return $query->where('status', 'ONGOING')->orderByDesc('started_at')->orderByDesc('id');
    }

    #[Scope]
    protected function completed(Builder $query): Builder
    {
        return $query->where('status', 'COMPLETED')->orderByDesc('completed_at')->orderByDesc('id');
    }
}
