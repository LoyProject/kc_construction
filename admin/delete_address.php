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

    $address_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$address_id) {
        $response['message'] = "Invalid address ID provided.";
        echo json_encode($response);
        exit;
    }

    try {
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM projects WHERE address_id = :address_id");
        $stmt_check->execute([':address_id' => $address_id]);
        $project_count = (int)$stmt_check->fetchColumn();

        if ($project_count > 0) {
            throw new Exception("Cannot delete. This address is assigned to {$project_count} project(s).");
        }

        $stmt_get_name = $pdo->prepare("SELECT name FROM addresses WHERE id = :id");
        $stmt_get_name->execute([':id' => $address_id]);
        $address_name = $stmt_get_name->fetchColumn();

        $stmt_delete = $pdo->prepare("DELETE FROM addresses WHERE id = :id");        
        if ($stmt_delete->execute([':id' => $address_id])) {
            if ($stmt_delete->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = "address '<span class=\"font-bold text-slate-700\">" . sanitize_output($address_name) . "</span>' was successfully deleted.";
            } else {
                throw new Exception("address not found or already deleted.");
            }
        } else {
            throw new Exception("Failed to execute the delete command in the database.");
        }
    } catch (Exception $e) {
        error_log("address deletion error: " . $e->getMessage());
        $response['message'] = $e->getMessage();
    }
    echo json_encode($response);
    exit;
?>
