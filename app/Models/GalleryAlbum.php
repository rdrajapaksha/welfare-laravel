<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\GalleryAlbumFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'slug', 'category', 'title_en', 'title_si', 'title_ta', 'caption_en', 'caption_si',
    'caption_ta', 'cover_image', 'taken_at', 'is_published',
])]
class GalleryAlbum extends Model
{
    /** @use HasFactory<GalleryAlbumFactory> */
    use HasFactory, HasTranslations;

    protected function casts(): array
    {
        return [
            'taken_at' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderByDesc('taken_at');
    }

    public function items(): HasMany
    {
        return $this->hasMany(GalleryItem::class);
    }
}
