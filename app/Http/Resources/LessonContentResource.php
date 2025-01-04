<?php

namespace App\Http\Resources;

use App\Models\Lesson;
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
        $contents = Lesson::find($this->lesson_id)->contents;

        return [
            'id' => $this->id,
            'type' => lcfirst(class_basename($this->contentable_type)),
            'lesson' => Lesson::find($this->lesson_id),
            'data' => match ($this->contentable_type) {
                Text::class => TextResource::make($this->morphModel()),
                Video::class => VideoResource::make($this->morphModel()),
            },
            'next_id' => $this->order < $contents->count() ? $contents->where('order', $this->order + 1)->first()->id : null,
            'prev_id' => $this->order > 1 ? $contents->where('order', $this->order - 1)->first()->id : null,
        ];
    }
}
