<?php

namespace milkovsky\hitster;

use GuzzleHttp\Client;

class QrCodeGenerator {

  public static function generate(string $content, $fileName, bool $force = FALSE): bool {
    $fileName = str_replace(['/', '?'], '', $fileName);
    $path = "codes/$fileName.png";
    if (!$force && file_exists($path)) {
        echo "Skipped existiing file '$path'<br>";
        return FALSE;
    }
    $key = $_ENV['QR_CODE_GENERATOR_KEY'];

    $client = new Client();
    $response = $client->post("https://api.qr-code-generator.com/v1/create?access-token=$key", [
      'form_params' => [
        'frame_name' => 'no-frame',
        'qr_code_text' => $content,
        'image_width' => 200,
        'image_format' => 'PNG',
      ]
    ]);

    file_put_contents($path, $response->getBody());

    return TRUE;
  }

}