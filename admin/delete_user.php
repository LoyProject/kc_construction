<?php
    require_once 'includes/admin_auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    header('Content-Type: application/json');
    $response = ['success' => false, 'message' => 'An unknown error occurred.'];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Invalid request method.';
        echo json_encode($response);
        exit;
    }

    $user_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$user_id) {
        $response['message'] = "Invalid user ID provided.";
        echo json_encode($response);
        exit;
    }

    try {
        $stmt_get_name = $pdo->prepare("SELECT username FROM users WHERE id = :id");
        $stmt_get_name->execute([':id' => $user_id]);
        $user_name = $stmt_get_name->fetchColumn();

        $stmt_delete = $pdo->prepare("DELETE FROM users WHERE id = :id");        
        if ($stmt_delete->execute([':id' => $user_id])) {
            if ($stmt_delete->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = "User '<span class=\"font-bold text-slate-700\">" . sanitize_output($user_name) . "</span>' was successfully deleted.";
            } else {
                throw new Exception("User not found or already deleted.");
            }
        } else {
            throw new Exception("Failed to execute the delete command in the database.");
        }
    } catch (Exception $e) {
        error_log("User deletion error: " . $e->getMessage());
        $response['message'] = $e->getMessage();
    }
    echo json_encode($response);
    exit;
?>
