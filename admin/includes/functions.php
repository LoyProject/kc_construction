<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    function sanitize_output($data) {
        return htmlspecialchars(trim($data ?? ''), ENT_QUOTES, 'UTF-8');
    }

    function format_currency($amount) {
        return '$ ' . number_format($amount, 2, '.', ',');
    }
?>
