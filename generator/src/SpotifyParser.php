<?php

namespace milkovsky\hitster;

class SpotifyParser {

    public static function isSongUrl(string $url): string {
        return preg_match('~^https://open.spotify.com/track/([^?]+)\?si=~', $url);
    }

    public static function getSongId(string $url): string {
        if (!preg_match('~^https://open.spotify.com/track/([^?]+)\?si=~', $url, $matches)) {
            throw new \Exception('Invalid URL ' .  $url);
        }
        return $matches[1];
    }

}