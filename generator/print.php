<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foldable Playing Cards for Sleeve 64x90 mm.</title>
    <style>
        @page { size: A4; margin: 10mm; }
        body { font-family: Arial, sans-serif; display: flex; flex-wrap: wrap; justify-content: center; }
        .page {
            width: 210mm;
            padding: 17mm 0 0 17mm;
        }
        @media print {
            .page {
                page-break-after: always;
            }
        }
        .row {
            display: flex;
            height: 109mm;
            padding-top: 19mm;
            width: 184mm;
        }
        .card-container {
            display: flex;
            width: 128mm;
            height: 90mm;
            border: 1px solid black;
            position: relative;
            transform: rotate(90deg);
            left: -16mm;
        }
        .card-container:nth-child(2) {
            left: -54mm;
        }
        .card {
            width: 64mm;
            height: 90mm;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 14px;
            border: 1px solid black;
            flex-direction: column;
        }
        .card-1 {
            background: #A3B0B9;
        }
        .card-2 {
            background: #B88A6A;
        }
        .card-3 {
            background: #B0C4B1;
        }
        .card-4 {
            background: #D8C48C;
        }
        .card-title {
            padding: 10mm;
        }
        .card-song-year {
            font-size: 4em;
        }
        .card-song-title {
            margin-top: 5mm;
        }
        .qr {
            background: #B4B8B6;
        }
        .qr-code img { width: 80%; height: auto; }
        .divider {
            position: absolute;
            top: 0;
            left: 50%;
            width: 1px;
            height: 100%;
            background: black;
        }
        .vladi {
            width: 30mm;
            height: auto;
        }
    </style>
</head>
<body>

<?php
require '../vendor/autoload.php';
use milkovsky\hitster\QrCodeGenerator;
use milkovsky\hitster\Songs;
$songs = Songs::getSongs();
?>
    <?php $count = 1 ?>
    <?php foreach ($songs as $song): ?>
        <?php if ($count === 1): ?><div class="page"><?php endif ?>
            <?php if ($count === 1 || $count === 3): ?><div class="row"><?php endif ?>
                <div class="card-container">
                    <div class="card card-<?= $count ?>">
                        <div class="card-title">
                            <div class="card-song-year"><?= $song['year'] ?></div>
                            <div class="card-song-title"><?= $song['artist'] . ' - ' . $song['title'] ?></div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="card qr">
                        <img class="vladi" src="img/vladi.webp" alt="The Vladi Rocks" height="50"/>
                        <img class="qr-code" src="codes/<?= QrCodeGenerator::fixFileName(Songs::getSongName($song)) ?>.png" alt="<?= Songs::getSongName($song) ?>"></div>
                </div>
        <?php if ($count === 2 || $count === 4): ?></div><?php endif ?>
        <?php if ($count === 4): ?></div><?php endif ?>
        <?php
            $count++;
            if ($count > 4) {
                $count = 1;
            }
        ?>
    <?php endforeach; ?>
</body>
</html>
