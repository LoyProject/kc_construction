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

    $size_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$size_id) {
        $response['message'] = "Invalid size ID provided.";
        echo json_encode($response);
        exit;
    }

    try {
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM projects WHERE size_id = :size_id");
        $stmt_check->execute([':size_id' => $size_id]);
        $project_count = (int)$stmt_check->fetchColumn();

        if ($project_count > 0) {
            throw new Exception("Cannot delete. This size is assigned to {$project_count} project(s).");
        }

        $stmt_get_name = $pdo->prepare("SELECT name FROM sizes WHERE id = :id");
        $stmt_get_name->execute([':id' => $size_id]);
        $size_name = $stmt_get_name->fetchColumn();

        $stmt_delete = $pdo->prepare("DELETE FROM sizes WHERE id = :id");        
        if ($stmt_delete->execute([':id' => $size_id])) {
            if ($stmt_delete->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = "size '<span class=\"font-bold text-slate-700\">" . sanitize_output($size_name) . "</span>' was successfully deleted.";
            } else {
                throw new Exception("size not found or already deleted.");
            }
        } else {
            throw new Exception("Failed to execute the delete command in the database.");
        }
    } catch (Exception $e) {
        error_log("size deletion error: " . $e->getMessage());
        $response['message'] = $e->getMessage();
    }
    echo json_encode($response);
    exit;
?>
