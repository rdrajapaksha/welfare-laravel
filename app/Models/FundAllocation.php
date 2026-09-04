<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\FundAllocationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'project_id', 'title_en', 'title_si', 'title_ta', 'description_en', 'description_si',
    'description_ta', 'amount', 'category', 'spent_at', 'proof_url',
])]
class FundAllocation extends Model
{
    /** @use HasFactory<FundAllocationFactory> */
    use HasFactory, HasTranslations;

    protected function casts(): array
    {
        return [
            'spent_at' => 'datetime',
            'amount' => 'integer',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
