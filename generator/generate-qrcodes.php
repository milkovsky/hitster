<?php

require '../vendor/autoload.php';

use milkovsky\hitster\QrCodeGenerator;
use milkovsky\hitster\Songs;
use milkovsky\hitster\SpotifyParser;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$songs = Songs::getSongs();

foreach ($songs as $song) {
    if (!SpotifyParser::isSongUrl($song['songLink'])) {
        echo "Skip invalid URL '{$song['songLink']}'<br>";
        continue;
    }
    $songName = Songs::getSongName($song);
    if (QrCodeGenerator::generate($song['songLink'], $songName)) {
        echo "Generated qr code for '$songName'<br>";
    }
}
