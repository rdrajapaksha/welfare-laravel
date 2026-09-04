<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\CommitteeMemberFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name', 'position_en', 'position_si', 'position_ta', 'bio_en', 'bio_si', 'bio_ta',
    'photo_url', 'email', 'phone', 'term_from', 'term_to', 'sort_order', 'is_current',
])]
class CommitteeMember extends Model
{
    /** @use HasFactory<CommitteeMemberFactory> */
    use HasFactory, HasTranslations;

    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
            'term_from' => 'integer',
            'term_to' => 'integer',
        ];
    }
}
