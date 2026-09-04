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
    'beneficiaries', 'status', 'started_at', 'completed_at', 'cover_image', 'document_path',
])]
class Project extends Model
{
    public const MAX_PHOTOS = 3;

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

    #[Scope]
    protected function ongoing(Builder $query): Builder
    {
        return $query->where('status', 'ONGOING')->orderByDesc('started_at')->orderByDesc('id');
    }
}
