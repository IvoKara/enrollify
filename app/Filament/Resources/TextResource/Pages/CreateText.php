<?php

namespace App\Filament\Resources\TextResource\Pages;

use App\Filament\Resources\TextResource;
use Filament\Resources\Pages\CreateRecord;

class CreateText extends CreateRecord
{
    protected static string $resource = TextResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['duration'] *= 60;

        return $data;
    }
}
