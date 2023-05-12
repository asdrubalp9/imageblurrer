<?php

require_once 'ImageBlurrer.php';
require 'vendor/autoload.php';

$blurrer = new ImageBlurrer();

$dir = new DirectoryIterator(dirname(__FILE__) . '/images');

foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $imagePath = $fileinfo->getPathname();
        $imageData = file_get_contents($imagePath);
        $base64Image = base64_encode($imageData);

        $blurredImage = $blurrer->blurImage($base64Image);

        // Do something with $blurredImage...
        // For testing purposes, let's just output it
        echo '<img src="' . $blurredImage . '" />';
    }
}
