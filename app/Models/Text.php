<?php

namespace App\Models;

use App\Traits\HasContentableMorph;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Text extends Model
{
    use HasContentableMorph;
    use HasFactory;

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

    public static function calculateDuration(string $text)
    {
        return ceil(str_word_count(strip_tags($text)) / 200) * 60;
    }

    public function getDuration()
    {
        return static::calculateDuration($this->content);
    }
}
