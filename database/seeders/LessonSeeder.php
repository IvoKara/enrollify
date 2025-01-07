<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::all()->each(function (Course $course) {
            Lesson::factory()->count(rand(3, 10))->create([
                'course_id' => $course->id,
                'user_id' => $course->user_id,
            ]);
        });
    }
}
