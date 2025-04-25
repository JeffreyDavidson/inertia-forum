<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discussion extends Model
{
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
}
