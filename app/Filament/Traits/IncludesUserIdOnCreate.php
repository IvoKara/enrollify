<?php

namespace App\Filament\Traits;

trait IncludesUserIdOnCreate
{
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
