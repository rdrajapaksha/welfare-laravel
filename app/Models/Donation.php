<?php

namespace App\Models;

use App\Support\DonationPurpose;
use Database\Factories\DonationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'reference', 'donor_name', 'email', 'phone', 'amount', 'currency', 'method', 'purpose', 'project_id',
    'message', 'is_anonymous', 'is_recurring', 'status', 'member_id', 'receipt_url', 'confirmed_at',
])]
class Donation extends Model
{
    /** @use HasFactory<DonationFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'is_recurring' => 'boolean',
            'confirmed_at' => 'datetime',
            'amount' => 'integer',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function destinationLabel(): string
    {
        return DonationPurpose::label($this->purpose, $this->project);
    }
}
