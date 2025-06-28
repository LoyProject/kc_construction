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

    $request_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$request_id) {
        $response['message'] = "Invalid request ID provided.";
        echo json_encode($response);
        exit;
    }

    try {
        $stmt_get_name = $pdo->prepare("SELECT name FROM requests WHERE id = :id");
        $stmt_get_name->execute([':id' => $request_id]);
        $request_name = $stmt_get_name->fetchColumn();

        $stmt_delete = $pdo->prepare("DELETE FROM requests WHERE id = :id");        
        if ($stmt_delete->execute([':id' => $request_id])) {
            if ($stmt_delete->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = "Request '<span class=\"font-bold text-slate-700\">" . sanitize_output($request_name) . "</span>' was successfully deleted.";
            } else {
                throw new Exception("Request not found or already deleted.");
            }
        } else {
            throw new Exception("Failed to execute the delete command in the database.");
        }
    } catch (Exception $e) {
        error_log("Request deletion error: " . $e->getMessage());
        $response['message'] = $e->getMessage();
    }
    echo json_encode($response);
    exit;
?>
