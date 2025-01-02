<?php

namespace App\Filament\Resources\TextResource\Pages;

use App\Filament\Resources\TextResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditText extends EditRecord
{
    protected static string $resource = TextResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['duration'] = ceil($data['duration'] / 60);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['duration'] *= 60;

        return $data;
    }
}
