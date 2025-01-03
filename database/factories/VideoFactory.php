<?php

namespace Database\Factories;

use App\Filament\Traits\HasRandomUserIdFactory;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    use HasRandomUserIdFactory;

    protected $model = Video::class;

    protected array $videoUrls = [
        'https://www.youtube.com/watch?v=gyU20BCnYtI',
        'https://youtu.be/3wz7YF2as-c?si=cdpAL329QLJLewyl',
        'https://youtu.be/aybSXT9ZJ8w?si=n2grK3ajoIEvyAcZ',
        'https://youtu.be/A_3MP_V-kB4?si=0Ssren3ktgHLAW5I',
        'https://youtu.be/Fz1oMAMisgE?si=hwvXJzYs1JK-O7mX',
        'https://youtu.be/D1FcYknxEY0?si=1uAlHzO7MSOeeIEJ',
        'https://youtu.be/VpAZPPCLCUI?si=utfWZILFGRGU_Bqv',
        'https://youtu.be/zLzN4BEQSSM?si=9J4G3TlFoJgdrd9J',
        'https://youtu.be/ioFvq38MNOE?si=cKUtiq1ExLksdS2b',
        'https://youtu.be/ivqIhXznT_Y?si=AkZOuPqIAwXLlGYF',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $url = $this->faker->randomElement($this->videoUrls);

        return [
            'url' => $url,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'duration' => Video::getVideoDuration($url),
            'user_id' => $this->randomUserId(),
        ];
    }
}
