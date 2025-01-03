<?php

namespace Database\Seeders;

use Awcodes\Curator\Database\Factories\MediaFactory;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MediaFactory::new()->createMany(10);
    }
}
