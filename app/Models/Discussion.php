<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Discussion extends Model
{
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function post(): HasOne
    {
        return $this->hasOne(Post::class)
            ->whereNull('parent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belognsTo(User::class);
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
}
