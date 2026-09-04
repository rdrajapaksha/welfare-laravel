<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\ElectionCandidateFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'election_id', 'name', 'position_en', 'position_si', 'position_ta', 'bio', 'sort_order',
])]
class ElectionCandidate extends Model
{
    /** @use HasFactory<ElectionCandidateFactory> */
    use HasFactory, HasTranslations;

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(ElectionVote::class);
    }
}
