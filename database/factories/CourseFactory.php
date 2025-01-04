<?php

namespace Database\Factories;

use App\Enums\CourseStatus;
use App\Filament\Traits\HasRandomUserIdFactory;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    use HasRandomUserIdFactory;

    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        $free = $this->faker->boolean();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'duration' => 0,
            'status' => $this->faker->randomElement(CourseStatus::values()),
            'is_free' => $free,
            'price' => $free ? 0 : $this->faker->randomFloat(2, 5, 50),
            'media_id' => $this->faker->numberBetween(1, 10),
            'user_id' => $this->randomUserId(),
            'meta_description' => $this->faker->sentence(10),
            'description' => $this->faker->paragraph(),
        ];
    }
}
