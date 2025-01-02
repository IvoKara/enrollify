<?php

namespace App\Traits;

use App\Models\LessonContent;
use Illuminate\Database\Eloquent\Model;

trait HasContentableMorph
{
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Model $model) {
            $model->contentable()->delete();
        });
    }

    public function contentable()
    {
        return LessonContent::query()
            ->where('contentable_id', $this->id)
            ->where('contentable_type', $this::class)
            ->first();
    }
}
