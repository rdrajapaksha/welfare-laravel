<?php

namespace App\Models;

use App\Support\MembershipDues;
use Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'membership_no', 'full_name', 'name_with_initials', 'nic', 'date_of_birth', 'gender',
    'civil_status', 'occupation', 'address_line1', 'address_line2', 'city', 'district',
    'phone', 'whatsapp', 'email', 'blood_group', 'photo_url', 'membership_type', 'status',
    'joined_at', 'emergency_name', 'emergency_phone', 'bio', 'show_in_directory', 'user_id',
])]
class Member extends Model
{
    /** @use HasFactory<MemberFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'joined_at' => 'datetime',
            'show_in_directory' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function benefitClaims(): HasMany
    {
        return $this->hasMany(BenefitClaim::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(ElectionVote::class);
    }

    public function suggestions(): HasMany
    {
        return $this->hasMany(Suggestion::class);
    }

    public function amountDue(): int
    {
        return MembershipDues::amountDue($this);
    }
}
