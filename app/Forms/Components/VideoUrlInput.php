<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Http;

class VideoUrlInput extends Field
{
    public ?string $iframe = null;

    protected string $view = 'forms.components.video-url-input';

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

    public static function getVideoId(string $url)
    {
        $paramsString = parse_url($url, PHP_URL_QUERY);
        parse_str($paramsString, $queryParams);

        return $queryParams['v'] ?? basename(parse_url($url, PHP_URL_PATH));
    }

    public function generateEmbedHtml(string $url): ?string
    {
        // Generate iframe embed HTML based on video URL
        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            $videoId = self::getVideoId($url);

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
