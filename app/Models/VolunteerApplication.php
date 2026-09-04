<?php

namespace App\Models;

use Database\Factories\VolunteerApplicationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'reference', 'full_name', 'email', 'phone', 'nic', 'city', 'district', 'date_of_birth',
    'interests', 'skills', 'availability', 'hours_per_month', 'experience', 'motivation',
    'status', 'reviewed_at',
])]
class VolunteerApplication extends Model
{
    /** @use HasFactory<VolunteerApplicationFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'reviewed_at' => 'datetime',
            'hours_per_month' => 'integer',
        ];
    }
}
