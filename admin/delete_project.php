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

    $project_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$project_id) {
        $response['message'] = "Invalid project ID.";
        echo json_encode($response);
        exit;
    }

    try {
        $pdo->beginTransaction();

        $stmt_get_images = $pdo->prepare("SELECT image_path FROM project_images WHERE project_id = :project_id");
        $stmt_get_images->execute([':project_id' => $project_id]);
        $image_paths_to_delete = $stmt_get_images->fetchAll(PDO::FETCH_COLUMN);

        $stmt_main_image = $pdo->prepare("SELECT image_path FROM projects WHERE id = :id");
        $stmt_main_image->execute([':id' => $project_id]);
        $main_image_path = $stmt_main_image->fetchColumn();
        if ($main_image_path && !in_array($main_image_path, $image_paths_to_delete)) {
            $image_paths_to_delete[] = $main_image_path;
        }
        
        $stmt_delete_project = $pdo->prepare("DELETE FROM projects WHERE id = :id"); 
        if ($stmt_delete_project->execute([':id' => $project_id])) {
            if ($stmt_delete_project->rowCount() > 0) {
                foreach ($image_paths_to_delete as $path) {
                    if (!empty($path) && file_exists($path)) {
                        if (!unlink($path)) {
                            error_log("Failed to delete image file: " . $path);
                        }
                    }
                }

                $pdo->commit();
                $response['success'] = true;
                $response['message'] = "project and all associated images deleted successfully.";
            } else {
                throw new Exception("project not found or already deleted.");
            }
        } else {
            throw new Exception("Failed to execute delete statement for the project.");
        }

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("project deletion error: " . $e->getMessage());
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
    exit;
?>
