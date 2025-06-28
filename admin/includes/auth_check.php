<?php
    if (session_status() == PHP_SESSION_NONE)
        session_start();

    if (!isset($_SESSION['user_id'])) {
        $_SESSION['message'] = "You must be logged in to access that page.";
        $_SESSION['message_type'] = "error";
        header("Location: login");
        exit;
    }
?>
