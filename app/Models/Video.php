<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Http;

class Video extends Model
{
    protected $fillable = [
        'title',
        'url',
        'order',
        'description',
        'user_id',
        'duration',
    ];

    public static function getVideoId(string $url)
    {
        $paramsString = parse_url($url, PHP_URL_QUERY);
        parse_str($paramsString, $queryParams);

        return $queryParams['v'] ?? basename(parse_url($url, PHP_URL_PATH));
    }

    public static function getVideoDuration(string $url)
    {
        $videoId = static::getVideoId($url);
        $apiKey = env('YOUTUBE_API_KEY');

        $response = Http::asJson()
            ->get(
                'https://www.googleapis.com/youtube/v3/videos',
                [
                    'id' => $videoId,
                    'part' => 'contentDetails',
                    'key' => $apiKey,
                ]
            );

        return CarbonInterval::make(
            $response->json('items.0.contentDetails.duration')
        )->totalSeconds;
    }

    public function getDurationAttribute($value): ?float
    {
        if ($value !== null) {
            return $value;
        } elseif ($this?->url === null) {
            return null;
        }

        $videoDuration = static::getVideoDuration($this->url);

        $this->duration = $videoDuration;
        $this->save();

        return $videoDuration;
    }

    public function thumbnail()
    {
        $videoId = static::getVideoId($this->url);

        // Return the thumbnail URL
        return url("https://img.youtube.com/vi/$videoId/sddefault.jpg");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
