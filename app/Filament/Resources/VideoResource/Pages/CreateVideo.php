<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use App\Filament\Traits\IncludesUserIdOnCreate;
use Filament\Resources\Pages\CreateRecord;

class CreateVideo extends CreateRecord
{
    use IncludesUserIdOnCreate;

    protected static string $resource = VideoResource::class;
}
