<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\MemberMeetingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title_en', 'title_si', 'title_ta', 'notes_en', 'notes_si', 'notes_ta',
    'host_name', 'host_address', 'held_at', 'is_published',
])]
class MemberMeeting extends Model
{
    /** @use HasFactory<MemberMeetingFactory> */
    use HasFactory, HasTranslations;

    protected function casts(): array
    {
        return [
            'held_at' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    public function isUpcoming(): bool
    {
        return $this->held_at->gte(now());
    }

    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    #[Scope]
    protected function upcoming(Builder $query): Builder
    {
        return $query->where('held_at', '>=', now())->orderBy('held_at')->orderBy('id');
    }

    #[Scope]
    protected function past(Builder $query): Builder
    {
        return $query->where('held_at', '<', now())->orderByDesc('held_at')->orderByDesc('id');
    }
}
