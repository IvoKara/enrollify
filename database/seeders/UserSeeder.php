<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::factory()->create([
            'name' => 'Enrollify Admin',
            'email' => 'admin@enrollify.com',
            'password' => bcrypt('admin@enrollify.com'),
        ]);

        $superAdmin->assignRole('super_admin');

        $creator = User::factory()->create([
            'name' => 'Demo Creator',
            'email' => 'creator@enrollify.com',
            'password' => bcrypt('creator@enrollify.com'),
        ]);

        $creator->assignRole(['panel_user', 'creator']);

        $anotherExternalCreator = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'password' => bcrypt('johndoe@gmail.com'),
        ]);

        $anotherExternalCreator->assignRole(['panel_user', 'creator']);
    }
}
