<?php

namespace App\Http\Resources;

use App\Models\Text;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonContentResource extends JsonResource
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
            'type' => lcfirst(class_basename($this->contentable_type)),
            'data' => match ($this->contentable_type) {
                Text::class => TextResource::make($this->morphModel()),
                Video::class => VideoResource::make($this->morphModel()),
            },
        ];
    }
}
