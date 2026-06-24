# App URL

https://milkovsky.github.io/hitster/

# Autoplays Spotify tracks by uri

Get parameters:
 - song-uri: Spotify song link like https://open.spotify.com/track/28POcTYQKfkjz6qTIvtjG1?si=3eb98567908045fd
 - secrets: optional flag to show the player.

# QR-Code reading

Reads QR-Codes, that contain Spotify song links like https://open.spotify.com/track/28POcTYQKfkjz6qTIvtjG1?si=3eb98567908045fd

# Local setup

To trigger qr-codes generation and printing, a local PHP server should be started.

1. `cp .env.dist .env`
2. Register at https://www.qr-code-generator.com/ and set `QR_CODE_GENERATOR_KEY={YOUR_KEY}` in the `.env`
3. (Optionally) set the `APPSERVER_PORT=`, default is `80`.
4. `make`
5. Visit `https://localhost:{APPSERVER_PORT}`

## Generate codes

1. Prepare songs.csv file from https://docs.google.com/spreadsheets/d/1AI46EhaWQqS64GgJ3U8yM6ArQ5vYYaFRnjKyMA7DowQ/edit?gid=0#gid=0
2. Open `https://localhost:{APPSERVER_PORT}/generate-qrcodes.php`
3. Codes are saved in codes/...

## Print cards

1. Visit in Google Chrome `https://localhost:{APPSERVER_PORT}/print.php` (FF does not show borders properly).
2. Ctrl + P
