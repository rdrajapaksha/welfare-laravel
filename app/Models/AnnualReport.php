<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\AnnualReportFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'year', 'title_en', 'title_si', 'title_ta', 'summary_en', 'summary_si', 'summary_ta',
    'file_url', 'file_size_kb', 'audited_by', 'total_income', 'total_expenditure',
    'welfare_spend', 'project_spend', 'admin_spend', 'reserve_balance',
    'members_at_year_end', 'is_published', 'published_at',
])]
class AnnualReport extends Model
{
    /** @use HasFactory<AnnualReportFactory> */
    use HasFactory, HasTranslations;

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'year' => 'integer',
        ];
    }
}
