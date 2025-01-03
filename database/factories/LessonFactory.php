<?php

namespace Database\Factories;

use App\Filament\Traits\HasRandomUserIdFactory;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    use HasRandomUserIdFactory;

    protected $model = Lesson::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = $this->randomUserId();

        return [
            'title' => $this->faker->sentence(3),
            'meta_description' => $this->faker->sentence(10),
            'overview' => $this->faker->paragraph(),
            'duration' => 0,
            'user_id' => $userId,
            'course_id' => $this->faker->randomElement(
                Course::where('user_id', $userId)->pluck('id'),
            ),
        ];
    }
}
