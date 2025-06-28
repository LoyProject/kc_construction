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

    $floor_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$floor_id) {
        $response['message'] = "Invalid floor ID provided.";
        echo json_encode($response);
        exit;
    }

    try {
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM projects WHERE floor_id = :floor_id");
        $stmt_check->execute([':floor_id' => $floor_id]);
        $project_count = (int)$stmt_check->fetchColumn();

        if ($project_count > 0) {
            throw new Exception("Cannot delete. This floor is assigned to {$project_count} project(s).");
        }

        $stmt_get_name = $pdo->prepare("SELECT name FROM floors WHERE id = :id");
        $stmt_get_name->execute([':id' => $floor_id]);
        $floor_name = $stmt_get_name->fetchColumn();

        $stmt_delete = $pdo->prepare("DELETE FROM floors WHERE id = :id");        
        if ($stmt_delete->execute([':id' => $floor_id])) {
            if ($stmt_delete->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = "floor '<span class=\"font-bold text-slate-700\">" . sanitize_output($floor_name) . "</span>' was successfully deleted.";
            } else {
                throw new Exception("floor not found or already deleted.");
            }
        } else {
            throw new Exception("Failed to execute the delete command in the database.");
        }
    } catch (Exception $e) {
        error_log("floor deletion error: " . $e->getMessage());
        $response['message'] = $e->getMessage();
    }
    echo json_encode($response);
    exit;
?>
