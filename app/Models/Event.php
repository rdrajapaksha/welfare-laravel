<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'slug', 'title_en', 'title_si', 'title_ta', 'summary_en', 'summary_si', 'summary_ta',
    'body_en', 'body_si', 'body_ta', 'venue', 'city', 'starts_at', 'ends_at', 'cover_image',
    'capacity', 'registration_open', 'is_published', 'attendee_count',
])]
class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory, HasTranslations;

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'registration_open' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('starts_at');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }
}
