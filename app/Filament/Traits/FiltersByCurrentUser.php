<?php

namespace App\Filament\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FiltersByCurrentUser
{
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
}
