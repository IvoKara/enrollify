<?php

namespace Database\Factories;

use App\Filament\Traits\HasRandomUserIdFactory;
use App\Models\Lesson;
use App\Models\LessonContent;
use App\Models\Text;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LessonContent>
 */
class LessonContentFactory extends Factory
{
    use HasRandomUserIdFactory;

    protected $model = LessonContent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $contentableType = $this->faker->randomElement([Text::class, Video::class]);
        $contentableId = $contentableType::all()->random()->id;

        return [
            'contentable_type' => $contentableType,
            'contentable_id' => $contentableId,
            'order' => $this->faker->numberBetween(1, 20),
            'lesson_id' => Lesson::all()->random()->id,
        ];
    }
}
