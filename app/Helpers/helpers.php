<?php

use Illuminate\Support\Str;

if (!function_exists('userAvatar')) {
    function userAvatar($path)
    {
        if (!$path) {
            return asset('default-avatar.png');
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset('storage/' . $path);
    }
}

if (!function_exists('getYoutubeEmbedUrl')) {
    function getYoutubeEmbedUrl($url)
    {
        if (!$url) return null;

        preg_match(
            '%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
            $url,
            $match
        );

        return isset($match[1]) ? 'https://www.youtube.com/embed/' . $match[1] : null;
    }
}
