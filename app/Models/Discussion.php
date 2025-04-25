<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discussion extends Model
{
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
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
