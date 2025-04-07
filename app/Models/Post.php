<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    ## Relations

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    ## Scope Methods

    public function scopeByTitle($query, string $title): Builder
    {
        return $query->where('title', 'like', "%$title%");
    }

    public function scopeByContent($query, string $content): Builder
    {
        return $query->where('content', 'like', "%$content%");
    }

    public function scopeByAuthor($query, string $authorName): Builder
    {
        return $query->whereHas('user', function ($authorQuery) use ($authorName) {
            $authorQuery->where('name', 'like', "%$authorName%");
        });
    }

    ## Other Methods

    public function ensureOfPostOwner()
    {
        if (auth()->id() != $this->user_id) {
            abort(403);
        }
    }

    public function remove(): bool
    {
        return $this->delete();
    }
}
