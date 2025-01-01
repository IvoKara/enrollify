<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    protected $fillable = [
        'title',
        'url',
        'order',
        'description',
        'user_id',
    ];

    public static function getVideoId(string $url)
    {
        $paramsString = parse_url($url, PHP_URL_QUERY);
        parse_str($paramsString, $queryParams);

        return $queryParams['v'] ?? basename(parse_url($url, PHP_URL_PATH));
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
