<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\DocumentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'slug', 'category', 'title_en', 'title_si', 'title_ta', 'description_en', 'description_si',
    'description_ta', 'file_url', 'file_type', 'file_size_kb', 'version', 'members_only',
    'download_count', 'is_published', 'published_at',
])]
class Document extends Model
{
    /** @use HasFactory<DocumentFactory> */
    use HasFactory, HasTranslations;

    protected function casts(): array
    {
        return [
            'members_only' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderByDesc('published_at');
    }
}
