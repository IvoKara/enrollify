<?php

namespace App\Forms\Components;

use App\Models\Video;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Http;

class VideoUrlInput extends Field
{
    protected string $view = 'forms.components.video-url-input';

    public ?string $iframe = null;

    public function fetchVideo()
    {
        $url = $this->getState();
        // dd($url);

        if (! $url) {

            return;
        }

        // dd($url);
        $response = Http::get($url);
        if ($response->successful()) {
            $this->iframe = $this->generateEmbedHtml($url);
        }

    }

    public function getIFrame(): ?string
    {
        return $this->iframe;
    }

    public function generateEmbedHtml(string $url): ?string
    {
        // Generate iframe embed HTML based on video URL
        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            $videoId = Video::getVideoId($url);

            return <<<HTML
                <iframe 
                    width="100%" height="230"
                    class="rounded-lg"
                    src="https://www.youtube.com/embed/{$videoId}" 
                    frameborder="0" 
                    allow="autoplay; encrypted-media" allowfullscreen>
                </iframe>
            HTML;
        }

        // Additional logic for other platforms like Vimeo, etc., can be added here
        return null;
    }
}
