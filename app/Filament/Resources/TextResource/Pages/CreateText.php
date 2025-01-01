<?php

namespace App\Filament\Resources\TextResource\Pages;

use App\Filament\Resources\TextResource;
use App\Filament\Traits\IncludesUserIdOnCreate;
use Filament\Resources\Pages\CreateRecord;

class CreateText extends CreateRecord
{
    use IncludesUserIdOnCreate;

    protected static string $resource = TextResource::class;
}
