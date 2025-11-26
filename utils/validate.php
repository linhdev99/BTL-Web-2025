<?php

/**
 * Validation Helper Functions
 */

/**
 * Validate email format
 */
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate required field
 */
function validateRequired($value)
{
    return !empty(trim($value));
}

/**
 * Validate minimum length
 */
function validateMinLength($value, $min)
{
    return strlen(trim($value)) >= $min;
}

/**
 * Validate maximum length
 */
function validateMaxLength($value, $max)
{
    return strlen(trim($value)) <= $max;
}

/**
 * Validate numeric value
 */
function validateNumeric($value)
{
    return is_numeric($value);
}

/**
 * Validate phone number (Vietnamese format)
 */
function validatePhone($phone)
{
    return preg_match('/^(0|\+84)[0-9]{9,10}$/', $phone);
}

/**
 * Validate image file
 */
function validateImage($file)
{
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return false;
    }

    $allowed_types = ALLOWED_IMAGE_TYPES;
    $file_type = mime_content_type($file['tmp_name']);

    if (!in_array($file_type, $allowed_types)) {
        return false;
    }

    if ($file['size'] > MAX_FILE_SIZE) {
        return false;
    }

    return true;
}
