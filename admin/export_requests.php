<?php
    require_once 'includes/admin_auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] !== 'Admin') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_requests");
        exit;
    }

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=export_requests.csv');

    $output = fopen('php://output', 'w');

    if (!$output) {
        die('Failed to open output stream');
    }

    fputcsv($output, ['id', 'name', 'tell', 'email', 'subject', 'message', 'created_at']);

    $sql = "SELECT id, name, tell, email, subject, message, created_at FROM requests";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result && count($result) > 0) {
        foreach ($result as $row) {
            fputcsv($output, $row);
        }
    }

    fclose($output);
    $pdo = null;
    exit;
?>
