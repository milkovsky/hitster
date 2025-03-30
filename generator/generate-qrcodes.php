<?php

require '../vendor/autoload.php';

use milkovsky\hitster\QrCodeGenerator;
use milkovsky\hitster\CsvParser;
use milkovsky\hitster\SpotifyParser;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$songs = CsvParser::getSongs();

foreach ($songs as $song) {
    if (!SpotifyParser::isSongUrl($song['songLink'])) {
        echo "Skip invalid URL '{$song['songLink']}'<br>";
        continue;
    }
    $fileName = "{$song['year']} {$song['artist']} - {$song['title']}";
    if (QrCodeGenerator::generate($song['songLink'], $fileName)) {
        echo "Generated qr code for '$fileName'<br>";
    }
}
