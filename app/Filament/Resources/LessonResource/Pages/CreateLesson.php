<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use App\Filament\Traits\IncludesUserIdOnCreate;
use Filament\Resources\Pages\CreateRecord;

class CreateLesson extends CreateRecord
{
    use IncludesUserIdOnCreate;

    protected static string $resource = LessonResource::class;
}
