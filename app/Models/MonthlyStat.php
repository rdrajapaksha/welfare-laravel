<?php

namespace App\Models;

use Database\Factories\MonthlyStatFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'year', 'month', 'donation_total', 'donation_count', 'new_members',
    'welfare_paid', 'claims_count', 'events_held', 'volunteers',
])]
class MonthlyStat extends Model
{
    /** @use HasFactory<MonthlyStatFactory> */
    use HasFactory;
}
