<?php

namespace App\Filament\Traits;

use App\Models\User;

trait HasRandomUserIdFactory
{
    protected function randomUserId(): string
    {
        return User::where(
            'email',
            $this->faker->randomElement(['creator@enrollify.com', 'johndoe@gmail.com'])
        )
            ->first()
            ->id;
    }
}
