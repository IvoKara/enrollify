<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            ShieldSeeder::class,
        ]);

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
    }
}
