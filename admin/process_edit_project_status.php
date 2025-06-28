<?php
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_projects");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit;
    }

    header('Content-Type: application/json');

    $response = ['success' => false, 'message' => 'An error occurred.'];

    $json_data = file_get_contents('php://input');
    $request_data = json_decode($json_data, true);

    $project_id = isset($request_data['project_id']) ? filter_var($request_data['project_id'], FILTER_VALIDATE_INT) : null;

    if (!$project_id) {
        $response['message'] = 'Invalid project ID.';
        echo json_encode($response);
        exit;
    }

    try {
        $stmt_get_status = $pdo->prepare("SELECT status FROM projects WHERE id = ?");
        $stmt_get_status->execute([$project_id]);
        $current_status = $stmt_get_status->fetchColumn();

        if (!$current_status) {
            throw new Exception('project not found.');
        }

        $new_status = ($current_status === 'Active') ? 'Inactive' : 'Active';

        $stmt_update = $pdo->prepare("UPDATE projects SET status = ? WHERE id = ?");
        
        if ($stmt_update->execute([$new_status, $project_id])) {
            $response['success'] = true;
            $response['new_status'] = $new_status;
            $response['message'] = 'Status updated to ' . $new_status;
        } else {
            throw new Exception('Failed to update project status.');
        }

    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
    exit;
?>
