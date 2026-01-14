<?php
/**
 * Security utilities for eOffice
 * Includes CSRF protection and other security helpers.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generate a CSRF token and store it in the session
 */
if (!function_exists('generate_csrf_token')) {
    function generate_csrf_token()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

/**
 * Get the current CSRF token
 */
if (!function_exists('get_csrf_token')) {
    function get_csrf_token()
    {
        return generate_csrf_token();
    }
}

/**
 * Verify if the provided CSRF token is valid
 */
if (!function_exists('verify_csrf_token')) {
    function verify_csrf_token($token)
    {
        if (!isset($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}

/**
 * Helper to output CSRF hidden input field
 */
if (!function_exists('csrf_field')) {
    function csrf_field()
    {
        $token = get_csrf_token();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }
}

/**
 * Helper for simple XSS clean (can be expanded)
 */
if (!function_exists('xss_clean')) {
    function xss_clean($data)
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}
?>