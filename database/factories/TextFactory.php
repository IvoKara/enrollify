<?php

namespace Database\Factories;

use App\Filament\Traits\HasRandomUserIdFactory;
use App\Models\Text;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Text>
 */
class TextFactory extends Factory
{
    use HasRandomUserIdFactory;

    protected $model = Text::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $content = $this->faker->paragraphs(
            $this->faker->numberBetween(5, 20),
            asText: true,
        );

        return [
            'title' => $this->faker->sentence(),
            'content' => $content,
            'duration' => Text::calculateDuration($content),
            'media_id' => $this->faker->boolean() ? $this->faker->numberBetween(1, 10) : null,
            'user_id' => $this->randomUserId(),
        ];
    }
}
