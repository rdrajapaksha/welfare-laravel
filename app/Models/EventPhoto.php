<?php

namespace App\Models;

use Database\Factories\EventPhotoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['event_id', 'path', 'sort_order'])]
class EventPhoto extends Model
{
    /** @use HasFactory<EventPhotoFactory> */
    use HasFactory;

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
