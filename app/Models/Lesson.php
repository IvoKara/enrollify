<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'overview',
        'is_free',
        'duration',
        'meta_description',
    ];
}
