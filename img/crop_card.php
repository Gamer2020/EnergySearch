<?php

require_once('../include.php');

function output_placeholder_image($width, $height)
{
    $placeholder_url = "https://placehold.co/{$width}x{$height}.png";
    $placeholder_image_data = @file_get_contents($placeholder_url);

    if ($placeholder_image_data === false) {
        die('Failed to load placeholder image');
    }

    header('Content-Type: image/png');
    echo $placeholder_image_data;
}

// Check if the image URL is provided
if (!isset($_GET['ID']) || empty($_GET['ID'])) {
    output_placeholder_image(205, 127);
    exit;
}

$url = get_card_image_by_id(sanitizeInput($_GET['ID']));

// Check if the URL is valid
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    output_placeholder_image(205, 127);
    exit;
}

// Load the image from the URL
$source_image = @imagecreatefrompng($url);

// Check if the image is loaded successfully
if (!$source_image) {
    output_placeholder_image(205, 127);
    exit;
}

header('Content-Type: image/png');

// Get the dimensions of the image
$width = imagesx($source_image);
$height = imagesy($source_image);

// Define the desired dimensions for the cropped image
$crop_width = 205;
$crop_height = 127;

// Calculate the position to crop the image
$x = 20;
$y = 34;

// Create a new image with the desired dimensions
$cropped_image = imagecreatetruecolor($crop_width, $crop_height);

// Preserve transparency for PNG images
imagealphablending($cropped_image, false);
imagesavealpha($cropped_image, true);
$transparent = imagecolorallocatealpha($cropped_image, 255, 255, 255, 127);
imagefilledrectangle($cropped_image, 0, 0, $crop_width, $crop_height, $transparent);

// Copy the cropped portion from the source image to the new image
imagecopyresampled($cropped_image, $source_image, 0, 0, $x, $y, $crop_width, $crop_height, $crop_width, $crop_height);

// Output the cropped image
imagepng($cropped_image);

// Free up memory
imagedestroy($source_image);
imagedestroy($cropped_image);