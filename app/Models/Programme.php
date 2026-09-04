<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\ProgrammeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'slug', 'category', 'title_en', 'title_si', 'title_ta', 'summary_en', 'summary_si', 'summary_ta',
    'body_en', 'body_si', 'body_ta', 'icon', 'cover_image', 'benefit_amount',
    'eligibility_en', 'eligibility_si', 'eligibility_ta', 'is_active', 'sort_order',
])]
class Programme extends Model
{
    /** @use HasFactory<ProgrammeFactory> */
    use HasFactory, HasTranslations;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'benefit_amount' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function benefitClaims(): HasMany
    {
        return $this->hasMany(BenefitClaim::class);
    }
}
