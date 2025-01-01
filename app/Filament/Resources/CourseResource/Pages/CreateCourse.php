<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use App\Filament\Traits\IncludesUserIdOnCreate;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    use IncludesUserIdOnCreate;

    protected static string $resource = CourseResource::class;
}
