<?php

namespace App\Http\Resources;

use App\Traits\HasFormattedDuration;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TextResource extends JsonResource
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
            'media' => \Awcodes\Curator\Models\Media::find($this->media_id),
            'duration' => CarbonInterval::seconds($this->duration)->cascade()->minutes.' min',
            'content' => $this->content,
        ];
    }
}
