<?php 

require_once('./Color2RGB.php');
$color2RGB = new Color2RGB;

// Path to our font file ()
$font = './arial.ttf';
$width = isset($_GET['width']) ? $_GET['width'] : 100;
$height = isset($_GET['height']) ? $_GET['height'] : $width;

$fontSize = isset($_GET['font']) ? $_GET['font'] : 16;
$text = isset($_GET['text']) ? $_GET['text'] : '??';
$background = isset($_GET['background']) ? $_GET['background'] : '000';
$color = isset($_GET['color']) ? $_GET['color'] : 'fff';

// Create image
$im = imagecreatetruecolor($width, $height);

$bgRGB = $color2RGB->render($background);
$colorRGB = $color2RGB->render($color);

$bgColor = imagecolorallocate($im, $bgRGB['R'], $bgRGB['G'], $bgRGB['B']);
$textColor = imagecolorallocate($im, $colorRGB['R'], $colorRGB['G'], $colorRGB['B']);

// Set the background
imagefilledrectangle($im, 0, 0, $width, $height, $bgColor);

// First we create our bounding box for the first text
$bbox = imagettfbbox($fontSize, 0, $font, $text);

// This is our cordinates for X and Y
$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
$y = $bbox[1] + (imagesy($im) / 2) - ($bbox[5] / 2);

// Write it
imagettftext($im, $fontSize, 0, $x, $y, $textColor, $font, $text);

// Output to browser
header('Content-Type: image/png');

imagepng($im);
imagedestroy($im);