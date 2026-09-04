<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\ElectionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'slug', 'title_en', 'title_si', 'title_ta', 'description_en', 'description_si',
    'description_ta', 'status', 'opens_at', 'closes_at',
])]
class Election extends Model
{
    /** @use HasFactory<ElectionFactory> */
    use HasFactory, HasTranslations;

    protected function casts(): array
    {
        return [
            'opens_at' => 'datetime',
            'closes_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    #[Scope]
    protected function open(Builder $query): Builder
    {
        return $query->where('status', 'OPEN')->orderByDesc('opens_at');
    }

    public function candidates(): HasMany
    {
        return $this->hasMany(ElectionCandidate::class)->orderBy('sort_order');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(ElectionVote::class);
    }
}
