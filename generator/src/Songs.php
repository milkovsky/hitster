<?php

namespace milkovsky\hitster;

class Songs {

    public static function getSongs(): array {
        $songs = [];
        $file = 'songs.csv';
        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',', '"', '\\')) !== false) {
                $song = [
                    'year' => $data[0],
                    'artist' => $data[1],
                    'title' => $data[2],
                    'songLink' => $data[3],
                ];
                $songs[] = $song;
            }

            fclose($handle);
        } else {
            throw new \Exception('Error opening file.');
        }

        return $songs;
    }

    public static function getSongName(array $song): string {
        return "{$song['year']} {$song['artist']} - {$song['title']}";
    }

}
