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

    $achievement_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$achievement_id) {
        $response['message'] = "Invalid achievement ID.";
        echo json_encode($response);
        exit;
    }

    try {
        $pdo->beginTransaction();

        $stmt_items_images = $pdo->prepare("SELECT image FROM achievement_items WHERE achievement_id = :achievement_id");
        $stmt_items_images->execute([':achievement_id' => $achievement_id]);
        $item_image_paths = $stmt_items_images->fetchAll(PDO::FETCH_COLUMN);

        $stmt_slideshow_images = $pdo->prepare("SELECT image_path FROM slideshow WHERE achievement_id = :achievement_id");
        $stmt_slideshow_images->execute([':achievement_id' => $achievement_id]);
        $slideshow_image_paths = $stmt_slideshow_images->fetchAll(PDO::FETCH_COLUMN);

        $image_paths_to_delete = array_merge($item_image_paths, $slideshow_image_paths);

        $stmt_delete_items = $pdo->prepare("DELETE FROM achievement_items WHERE achievement_id = :achievement_id");
        $stmt_delete_items->execute([':achievement_id' => $achievement_id]);

        $stmt_delete_slideshow = $pdo->prepare("DELETE FROM slideshow WHERE achievement_id = :achievement_id");
        $stmt_delete_slideshow->execute([':achievement_id' => $achievement_id]);

        $stmt_delete_achievement = $pdo->prepare("DELETE FROM achievements WHERE id = :id");
        if ($stmt_delete_achievement->execute([':id' => $achievement_id])) {
            if ($stmt_delete_achievement->rowCount() > 0) {
                foreach ($image_paths_to_delete as $path) {
                    if (!empty($path) && file_exists($path)) {
                        if (!unlink($path)) {
                            error_log("Failed to delete image file: " . $path);
                        }
                    }
                }

                $pdo->commit();
                $response['success'] = true;
                $response['message'] = "Achievement and all associated items, slideshow, and images deleted successfully.";
            } else {
                throw new Exception("Achievement not found or already deleted.");
            }
        } else {
            throw new Exception("Failed to execute delete statement for the achievement.");
        }

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("Achievement deletion error: " . $e->getMessage());
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
    exit;
?>
