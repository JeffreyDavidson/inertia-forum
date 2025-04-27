<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Discussion extends Model
{
    use Searchable;

    public function toSearchableArray()
    {
        return $this->only('id', 'title');
    }

    protected static function booted()
    {
        static::created(function ($discussion) {
            $discussion->update(['slug' => $discussion->title]);
        });
    }

    protected $fillable = [
        'title',
        'slug',
    ];

    /**
     * Interact with the user's first name.
     */
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => $this->id.'-'.Str::slug($value)
        );
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Post::class)
            ->whereNotNull('parent_id');
    }

    public function post(): HasOne
    {
        return $this->hasOne(Post::class)
            ->whereNull('parent_id');
    }

    public function latestPost(): HasOne
    {
        return $this->hasOne(Post::class)
            ->latestOfMany();
    }

    public function participants(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Post::class, 'discussion_id', 'id', 'id', 'user_id')
            ->distinct();
    }

    public function solution(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'solution_post_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPinned()
    {
        return ! is_null($this->pinned_at);
    }

    #[Scope]
    public function orderByPinned($query)
    {
        $query->orderBy('pinned_at', 'desc');
    }

    #[Scope]
    public function orderByLastPost($query)
    {
        $query->orderBy(
            Post::select('created_at')
                ->whereColumn('posts.discussion_id', 'discussions.id')
                ->latest()
                ->take(1),
            'desc'
        );
    }
}
