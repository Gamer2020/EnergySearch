<?php

function sanitizeInput($input)
{
    // Ensure $input is a string
    $input = @strval($input);

    // Remove whitespace from the beginning and end of the input
    $input = trim($input);

    // Strip HTML and PHP tags from the input
    $input = strip_tags($input);

    // Replace quotes with their HTML entities to prevent SQL injection attacks
    $input = str_replace("'", "&#39;", $input);
    $input = str_replace("\"", "&quot;", $input);

    // Use htmlspecialchars to prevent XSS attacks
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

    return $input;
}

function sanitizeArray($array)
{
    if (!is_array($array)) {
        return sanitizeInput($array);
    }

    foreach ($array as $key => &$value) {
        $value = sanitizeArray($value);
    }

    return $array;
}

function getFirstWord($inputString)
{
    $words = explode(' ', $inputString);
    return $words[0];
}

function containsStringIgnoreCase($haystack, $needle)
{
    return stripos($haystack, $needle) !== false;
}

function limitStringLength($string, $maxLength)
{
    if (strlen($string) > $maxLength) {
        $limitedString = substr($string, 0, $maxLength) . "...";
    } else {
        $limitedString = $string;
    }
    return $limitedString;
}

function get_user_ip() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $user_ip = $_SERVER['REMOTE_ADDR'];
    }

    return $user_ip;
}

?>