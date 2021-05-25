<?php

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

function generateQr(string $text, bool $send = false) {
    try {
        $options = new QROptions(array(
            'version' => 7,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'imageBase64' => false,
            'eccLevel' => QRCode::ECC_L,
        ));

        $qrcode = new QRCode($options);
        $svg = $qrcode->render($text);
        if ($send) {
            header('Content-type: image/svg+xml');
            echo $svg;
        } else {
            return $svg;
        }
    } catch (Exception $e) {
        echo 'Exception reçue : ', $e->getMessage(), "\n";
    }
}
?>
