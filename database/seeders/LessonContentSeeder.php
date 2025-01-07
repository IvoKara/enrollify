<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\LessonContent;
use Illuminate\Database\Seeder;

class LessonContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lesson::all()->each(function (Lesson $lesson) {

            $contents = LessonContent::factory()->count(rand(3, 10))->make([
                'lesson_id' => $lesson->id,
            ]);

            $contents->each(function (LessonContent $content, int $index) use ($lesson) {
                $type = $content->contentable_type;
                $id = $type::where('user_id', $lesson->user_id)->get()->random()->id;
                $content->contentable_id = $id;
                $content->order = $index + 1;
                $content->save();
            });
        });
    }
}
