<?php

namespace App\Models;

use App\Traits\HasContentableMorph;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Text extends Model
{
    use HasContentableMorph;

    protected $fillable = [
        'media_id',
        'content',
        'title',
        'user_id',
        'duration',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
