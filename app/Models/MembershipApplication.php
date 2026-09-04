<?php

namespace App\Models;

use Database\Factories\MembershipApplicationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'application_no', 'full_name', 'nic', 'date_of_birth', 'gender', 'occupation',
    'address_line1', 'city', 'district', 'phone', 'email', 'membership_type',
    'referred_by', 'motivation', 'status', 'review_note', 'decided_at',
])]
class MembershipApplication extends Model
{
    /** @use HasFactory<MembershipApplicationFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'decided_at' => 'datetime',
        ];
    }
}
