<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\NewsPostFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'slug', 'category', 'title_en', 'title_si', 'title_ta', 'excerpt_en', 'excerpt_si', 'excerpt_ta',
    'body_en', 'body_si', 'body_ta', 'cover_image', 'document_path', 'author', 'tags', 'is_featured',
    'is_published', 'views', 'published_at',
])]
class NewsPost extends Model
{
    /** @use HasFactory<NewsPostFactory> */
    use HasFactory, HasTranslations;

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
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
        return $query->where('is_published', true)->orderByDesc('published_at')->orderByDesc('id');
    }
}
