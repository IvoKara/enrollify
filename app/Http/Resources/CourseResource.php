<?php

namespace App\Http\Resources;

use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'url' => '/courses/'.$this->slug,
            'description' => $this->description,
            'meta_description' => $this->meta_description,
            'duration' => $this->formatDuration($this->duration),
            'media' => \Awcodes\Curator\Models\Media::find($this->media_id),
            'status' => $this->status,
            'lessons' => $this->lessons,
            'is_free' => (bool) $this->is_free,
            'price' => '$'.$this->price,
            'creator' => User::find($this->user_id),
        ];
    }

    public function formatDuration(int $duration): string
    {
        $interval = CarbonInterval::seconds($duration)->cascade();

        $formatted = [];

        if ($interval->hours > 0) {
            $formatted[] = $interval->hours.'h';
        }

        if ($interval->minutes > 0) {
            $formatted[] = $interval->minutes.'m';
        }

        $formatted[] = $interval->seconds.'s';

        return implode(' ', $formatted);
    }
}
