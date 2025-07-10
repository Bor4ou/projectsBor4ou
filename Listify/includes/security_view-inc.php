<?php
declare(strict_types=1);

/**
 * Echoes any security‐question errors from the session.
 */
function output_security_errors(): void {
    if (! empty($_SESSION['errors_security'])) {
        foreach ($_SESSION['errors_security'] as $err) {
            echo "<p class='error'>{$err}</p>";
        }
        unset($_SESSION['errors_security']);
    }
}

/**
 * Echoes a one-time success message for setting the security question.
 */
function output_security_success(): void {
    if (isset($_SESSION['success_security'])) {
        echo "<p class='success'>{$_SESSION['success_security']}</p>";
        unset($_SESSION['success_security']);
    }
}