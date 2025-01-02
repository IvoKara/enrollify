<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonContent extends Model
{
    use HasFactory;

    public $fillable = [
        'lesson_id',
        'contentable_id',
        'contentable_type',
        'order',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function morphModel(): Text|Video
    {
        return $this->contentable_type::find($this->contentable_id);
    }
}
