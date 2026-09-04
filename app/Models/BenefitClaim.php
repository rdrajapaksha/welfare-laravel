<?php

namespace App\Models;

use Database\Factories\BenefitClaimFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'claim_no', 'member_id', 'programme_id', 'amount', 'reason', 'status',
    'document_url', 'review_note', 'submitted_at', 'decided_at', 'paid_at',
])]
class BenefitClaim extends Model
{
    /** @use HasFactory<BenefitClaimFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'decided_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class);
    }
}
