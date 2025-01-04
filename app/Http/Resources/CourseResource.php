<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Traits\HasFormattedDuration;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'meta_description' => $this->meta_description,
            'duration' => $this->getFormattedDuration(),
            'media' => \Awcodes\Curator\Models\Media::find($this->media_id),
            'status' => $this->status,
            'lessons' => LessonResource::collection($this->lessons),
            'is_free' => (bool) $this->is_free,
            'price' => '$'.$this->price,
            'creator' => User::find($this->user_id),
        ];
    }
}
