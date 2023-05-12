<?php

require 'vendor/autoload.php';

use Aws\Rekognition\RekognitionClient;
use Intervention\Image\ImageManager;

class ImageBlurrer
{
    private $client;
    private $imageManager;

    public function __construct($accessKey = null, $secretKey = null)
    {
        $config = [
            'version' => 'latest',
            'region'  => 'us-west-2' // Cambia esto a tu región
        ];

        if ($accessKey && $secretKey) {
            $config['credentials'] = [
                'key'    => $accessKey,
                'secret' => $secretKey,
            ];
        }

        $this->client = new RekognitionClient($config);

        $this->imageManager = new ImageManager(['driver' => 'gd']);
    }

    public function blurImage($base64Image)
    {
        // Habilitar la visualización de errores
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Detectar texto en la imagen
        $result = $this->client->detectText([
            'Image' => [
                'Bytes' => base64_decode($base64Image),
            ],
        ]);

        $image = $this->imageManager->make($base64Image);

        // Para cada texto detectado
        foreach ($result['TextDetections'] as $textDetection) {
            $text = $textDetection['DetectedText'];
            $text = strtolower($text); // Convertir a minúsculas
            $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text); // Eliminar acentos
            $text = preg_replace('/[^a-zA-Z0-9]/', '', $text); // Eliminar caracteres especiales y guiones
            $text = str_replace(' ', '', $text); // Eliminar espacios

            // Verificar si el texto cumple con la expresión regular
            if (preg_match('/^(?:[A-Z]{2}[1-9]{1}[0-9]{3}|[BCDFGHJKLPRSTVWXYZ]{4}[0-9]{2}|[A-Z]{2}[0-9]{3}|[BCDFGHJKLPRSTVWXYZ]{3}[0-9]{2}|[A-Z]{2}[0]{1}[0-9]{3}|[BCDFGHJKLPRSTVWXYZ]{3}[0]{1}[0-9]{2}|[A-Z]{2}[O]{1}[0-9]{3}|[BCDFGHJKLPRSTVWXYZ]{3}[O]{1}[0-9]{2}|[A-Z]{2}[A-Z]{2}[0-9]{2})$/i', $text)) {
                $box = $textDetection['Geometry']['BoundingBox'];
                $width = $image->width();
                $height = $image->height();
                $image->rectangle($box['Left'] * $width, $box['Top'] * $height, ($box['Left'] + $box['Width']) * $width, ($box['Top'] + $box['Height']) * $height, function ($draw) {
                    $draw->background('#000');
                });
            }
        }

        // Verificar si hubo un error
        $error = error_get_last();
        if ($error) {
            throw new Exception($error['message'], $error['type']);
        }

        // Convertir la imagen a base64 y devolverla
        return (string) $image->encode('data-url');
    }
}
