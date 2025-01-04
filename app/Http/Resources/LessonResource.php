<?php

namespace App\Http\Resources;

use App\Traits\HasFormattedDuration;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    use HasFormattedDuration;

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
            'meta_description' => $this->meta_description,
            'overview' => $this->overview,
            'duration' => $this->getFormattedDuration(),
            'contents' => LessonContentResource::collection($this->contents),
        ];
    }
}
