<?php

namespace App\Models;

use App\Enums\CommitteeBoard;
use App\Models\Concerns\HasTranslations;
use Database\Factories\CommitteeMemberFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name', 'position_en', 'position_si', 'position_ta', 'bio_en', 'bio_si', 'bio_ta',
    'photo_url', 'email', 'phone', 'term_from', 'term_to', 'sort_order', 'is_current', 'board',
])]
class CommitteeMember extends Model
{
    /** @use HasFactory<CommitteeMemberFactory> */
    use HasFactory, HasTranslations;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'board' => 'EXECUTIVE',
        'is_current' => true,
    ];

    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
            'term_from' => 'integer',
            'term_to' => 'integer',
            'board' => CommitteeBoard::class,
        ];
    }

    #[Scope]
    protected function current(Builder $query): Builder
    {
        return $query->where('is_current', true)->orderBy('sort_order');
    }

    #[Scope]
    protected function executive(Builder $query): Builder
    {
        return $query->where('board', CommitteeBoard::Executive);
    }

    #[Scope]
    protected function advisory(Builder $query): Builder
    {
        return $query->where('board', CommitteeBoard::Advisory);
    }
}
