<?php
    require_once 'auth_check.php';

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        $_SESSION['message'] = "You do not have permission to access that page.";
        $_SESSION['message_type'] = "error";
        header("Location: index");
        exit;
    }
?>