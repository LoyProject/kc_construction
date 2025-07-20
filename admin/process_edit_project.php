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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_edit_project'])) {        
        $project_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $form_data_for_repopulation = $_POST;

        if (!$project_id) {
            $_SESSION['message'] = "Invalid project ID. Update failed.";
            $_SESSION['message_type'] = "error";
            header("Location: manage_projects");
            exit;
        }

        $core_errors = [];
        if (empty($_POST['name']))
            $core_errors[] = "Project name is required.";
        if (empty($_POST['style_id']) || !filter_var($_POST['style_id'], FILTER_VALIDATE_INT))
            $core_errors[] = "Please select a valid style.";
        if (empty($_POST['type_id']) || !filter_var($_POST['type_id'], FILTER_VALIDATE_INT))
            $core_errors[] = "Please select a valid type.";
        if (empty($_POST['floor_id']) || !filter_var($_POST['floor_id'], FILTER_VALIDATE_INT))
            $core_errors[] = "Please select a valid number of floors.";
        // if (empty($_POST['facade_id']) || !filter_var($_POST['facade_id'], FILTER_VALIDATE_INT))
        //     $core_errors[] = "Please select a valid facade.";
        if (empty($_POST['facade']))
            $core_errors[] = "Facade is required.";
        // if (empty($_POST['area_id']) || !filter_var($_POST['area_id'], FILTER_VALIDATE_INT))
        //     $core_errors[] = "Please select a valid area.";
        if (empty($_POST['area']))
            $core_errors[] = "Area is required.";
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $max_file_size = 3 * 1024 * 1024; // 3MB
            foreach ($_FILES['images']['size'] as $idx => $size) {
                if ($size > $max_file_size) {
                    $core_errors[] = "Each image must be less than or equal to 3MB.";
                    break;
                }
            }
        }

        $name = trim($_POST['name']);
        $style_id = filter_input(INPUT_POST, 'style_id', FILTER_VALIDATE_INT) ?: null;
        $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT) ?: null;
        $floor_id = filter_input(INPUT_POST, 'floor_id', FILTER_VALIDATE_INT) ?: null;
        // $facade_id = filter_input(INPUT_POST, 'facade_id', FILTER_VALIDATE_INT) ?: null;
        $facade = trim($_POST['facade']) ?: null;
        // $area_id = filter_input(INPUT_POST, 'area_id', FILTER_VALIDATE_INT) ?: null;
        $area = trim($_POST['area']) ?: null;
        // $size_id = filter_input(INPUT_POST, 'size_id', FILTER_VALIDATE_INT) ?: null;
        $size = trim($_POST['size']) ?: null;
        $view = filter_input(INPUT_POST, 'view', FILTER_VALIDATE_INT) ?: 0;
        $investor = trim($_POST['investor']) ?: null;
        // $address_id = filter_input(INPUT_POST, 'address_id', FILTER_VALIDATE_INT) ?: null;
        $address = trim($_POST['address']) ?: null;
        $implement_at = filter_input(INPUT_POST, 'implement_at', FILTER_VALIDATE_INT) ?: null;
        $implement_unit = trim($_POST['implement_unit']) ?: null;
        $budget = trim($_POST['budget']) ?: null;
        $detail_floor = trim($_POST['detail_floor']) ?: null;
        $detail_area = trim($_POST['detail_area']) ?: null;
        $video = trim($_POST['video']) ?: null;

        $current_image_count = 0;
        if (empty($core_errors)) {
            try {
                $stmt_count = $pdo->prepare("SELECT COUNT(id) FROM project_images WHERE project_id = :project_id");
                $stmt_count->bindParam(':project_id', $project_id, PDO::PARAM_INT);
                $stmt_count->execute();
                $current_image_count = (int)$stmt_count->fetchColumn();
            } catch (PDOException $e) {
                error_log("Error counting images for project $project_id: " . $e->getMessage());
                $core_errors[] = "Could not verify current image count to validate deletion.";
            }

            $images_to_delete_ids = isset($_POST['delete_images']) && is_array($_POST['delete_images'])
                ? array_map('intval', $_POST['delete_images'])
                : [];
            $count_images_marked_for_deletion = count($images_to_delete_ids);

            $count_images_attempted = 0;
            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                foreach($_FILES['images']['error'] as $error_code){
                    if($error_code === UPLOAD_ERR_OK){
                        $count_images_attempted++;
                    }
                }
            }
            
            if ($current_image_count > 0 && $count_images_marked_for_deletion >= $current_image_count && $count_images_attempted == 0) {
                $core_errors[] = "Cannot delete all images. A project must have at least one image. Please upload a new image if you wish to replace all current ones.";
            }
        }

        if (!empty($core_errors)) {
            $_SESSION['form_errors'] = $core_errors;
            $_SESSION['form_data'] = $form_data_for_repopulation;
            $_SESSION['message'] = "Please correct the errors below.";
            $_SESSION['message_type'] = "error";
            header("Location: edit_project?id=" . $project_id);
            exit;
        }

        $core_update_successful = false;
        try {
            $sql_update_project = "UPDATE projects SET 
                name = :name,
                style_id = :style_id,
                type_id = :type_id,
                floor_id = :floor_id,
                -- facade_id = :facade_id,
                facade = :facade,
                -- area_id = :area_id,
                area = :area,
                -- size_id = :size_id,
                size = :size,
                view = :view,
                investor = :investor,
                -- address_id = :address_id,
                address = :address,
                implement_at = :implement_at,
                implement_unit = :implement_unit,
                budget = :budget,
                detail_floor = :detail_floor,
                detail_area = :detail_area,
                video = :video
            WHERE id = :id";
            
            $stmt_update_project = $pdo->prepare($sql_update_project);
            $stmt_update_project->bindParam(':name', $name);
            $stmt_update_project->bindParam(':style_id', $style_id, PDO::PARAM_INT);
            $stmt_update_project->bindParam(':type_id', $type_id, PDO::PARAM_INT);
            $stmt_update_project->bindParam(':floor_id', $floor_id, PDO::PARAM_INT);
            // $stmt_update_project->bindParam(':facade_id', $facade_id, PDO::PARAM_INT);
            $stmt_update_project->bindParam(':facade', $facade);
            // $stmt_update_project->bindParam(':area_id', $area_id, PDO::PARAM_INT);
            $stmt_update_project->bindParam(':area', $area);
            // $stmt_update_project->bindParam(':size_id', $size_id, PDO::PARAM_INT);
            $stmt_update_project->bindParam(':size', $size);
            $stmt_update_project->bindParam(':view', $view, PDO::PARAM_INT);
            $stmt_update_project->bindParam(':investor', $investor);
            // $stmt_update_project->bindParam(':address_id', $address_id, PDO::PARAM_INT);
            $stmt_update_project->bindParam(':address', $address);
            $stmt_update_project->bindParam(':implement_at', $implement_at, PDO::PARAM_INT);
            $stmt_update_project->bindParam(':implement_unit', $implement_unit);
            $stmt_update_project->bindParam(':budget', $budget);
            $stmt_update_project->bindParam(':detail_floor', $detail_floor);
            $stmt_update_project->bindParam(':detail_area', $detail_area);
            $stmt_update_project->bindParam(':video', $video);
            $stmt_update_project->bindParam(':id', $project_id, PDO::PARAM_INT);

            if ($stmt_update_project->execute()) {
                $core_update_successful = true;
            } else {
                $_SESSION['message'] = "Failed to update project core details.";
                $_SESSION['message_type'] = "error";
                header("Location: edit_project?id=" . $project_id);
                exit;
            }
        } catch (PDOException $e) {
            error_log("Database error on project core update: " . $e->getMessage());
            $_SESSION['message'] = "Database error updating project details: <span class=\"font-semibold\">" . sanitize_output($e->getMessage()) . "</span>";
            $_SESSION['message_type'] = "error";
            $_SESSION['form_data'] = $form_data_for_repopulation;
            header("Location: edit_project?id=" . $project_id);
            exit;
        }

        $image_deletion_messages = [];
        if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
            foreach ($images_to_delete_ids as $id_to_delete) {
                if ($id_to_delete) {
                    try {
                        $stmt_get_path = $pdo->prepare("SELECT image_path FROM project_images WHERE id = :id AND project_id = :project_id");
                        $stmt_get_path->execute([':id' => $id_to_delete, ':project_id' => $project_id]);
                        $path_to_delete = $stmt_get_path->fetchColumn();

                        $stmt_delete_img_db = $pdo->prepare("DELETE FROM project_images WHERE id = :id AND project_id = :project_id");
                        if ($stmt_delete_img_db->execute([':id' => $id_to_delete, ':project_id' => $project_id])) {
                            if ($path_to_delete && file_exists($path_to_delete)) {
                                if (unlink($path_to_delete)) {
                                    $image_deletion_messages[] = "Image (ID: $id_to_delete) deleted.";
                                } else {
                                    $image_deletion_messages[] = "DB record for image ID $id_to_delete deleted, but failed to delete file.";
                                    error_log("Failed to delete image file: " . $path_to_delete);
                                }
                            } else {
                                $image_deletion_messages[] = "Image (ID: $id_to_delete) DB record deleted. File not found for unlinking.";
                            }
                        } else {
                            $image_deletion_messages[] = "Failed to delete DB record for image ID $id_to_delete.";
                        }
                    } catch (PDOException $e) {
                        error_log("Error deleting image ID $id_to_delete: " . $e->getMessage());
                        $image_deletion_messages[] = "Error processing deletion for image ID $id_to_delete.";
                    }
                }
            }
        }

        $image_upload_messages = [];
        if (isset($_FILES['images'])) {
            $uploaded_files = $_FILES['images'];
            $target_dir = "assets/images/projects/";

            for ($i = 0; $i < count($uploaded_files['name']); $i++) {
                if ($uploaded_files['error'][$i] == UPLOAD_ERR_OK) {
                    $tmp_name = $uploaded_files['tmp_name'][$i];
                    $original_name = basename($uploaded_files['name'][$i]);
                    $file_size = $uploaded_files['size'][$i];
                    
                    $image_file_type = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
                    $new_file_name = uniqid('proj_' . $project_id . '_', true) . '.' . $image_file_type;
                    $target_file_path = $target_dir . $new_file_name;

                    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                    $max_file_size = 3 * 1024 * 1024; // 3MB

                    if (!in_array($image_file_type, $allowed_types)) {
                        $image_upload_messages[] = "File '".sanitize_output($original_name)."': Invalid type."; continue;
                    }
                    if ($file_size > $max_file_size) {
                        $image_upload_messages[] = "File '".sanitize_output($original_name)."': Too large."; continue;
                    }
                    if ($file_size == 0){
                        $image_upload_messages[] = "File '".sanitize_output($original_name)."': Empty file."; continue;
                    }

                    if (move_uploaded_file($tmp_name, $target_file_path)) {
                        try {
                            $stmt_insert_image = $pdo->prepare("INSERT INTO project_images (project_id, image_path, is_primary) VALUES (:project_id, :image_path, FALSE)");
                            $stmt_insert_image->execute([':project_id' => $project_id, ':image_path' => $target_file_path]);
                            $image_upload_messages[] = "New image '".sanitize_output($original_name)."' uploaded.";
                        } catch (PDOException $e) {
                            error_log("DB Error inserting new image ".$target_file_path.": " . $e->getMessage());
                            $image_upload_messages[] = "Image '".sanitize_output($original_name)."' uploaded but DB save failed.";
                            if(file_exists($target_file_path)) unlink($target_file_path);
                        }
                    } else {
                        $image_upload_messages[] = "Failed to upload new image '".sanitize_output($original_name)."'.";
                    }
                } elseif ($uploaded_files['error'][$i] != UPLOAD_ERR_NO_FILE) {
                    $image_upload_messages[] = "Error with file '".sanitize_output($uploaded_files['name'][$i])."' (Code: ".$uploaded_files['error'][$i].").";
                }
            }
        }

        $primary_image_path_for_project_table = null; 
        $primary_selection_messages = [];
        try {
            $current_primary_id_in_db = null;
            $current_primary_image_path_in_db = null;

            $stmt_get_current_primary = $pdo->prepare("SELECT id, image_path FROM project_images WHERE project_id = :project_id AND is_primary = TRUE LIMIT 1");
            $stmt_get_current_primary->execute([':project_id' => $project_id]);
            $current_primary_details = $stmt_get_current_primary->fetch(PDO::FETCH_ASSOC);
            if($current_primary_details){
                $current_primary_id_in_db = $current_primary_details['id'];
                $current_primary_image_path_in_db = $current_primary_details['image_path'];
            }

            $newly_selected_primary_id = filter_input(INPUT_POST, 'primary_id', FILTER_VALIDATE_INT);

            if ($newly_selected_primary_id) {
                if ($newly_selected_primary_id != $current_primary_id_in_db) {
                    $stmt_check_exists = $pdo->prepare("SELECT image_path FROM project_images WHERE id = :id AND project_id = :project_id");
                    $stmt_check_exists->execute([':id' => $newly_selected_primary_id, ':project_id' => $project_id]);
                    $new_primary_path_candidate = $stmt_check_exists->fetchColumn();

                    if ($new_primary_path_candidate) {
                        $pdo->prepare("UPDATE project_images SET is_primary = FALSE WHERE project_id = :project_id")->execute([':project_id' => $project_id]);
                        $pdo->prepare("UPDATE project_images SET is_primary = TRUE WHERE id = :id")->execute([':id' => $newly_selected_primary_id]);
                        $primary_image_path_for_project_table = $new_primary_path_candidate;
                        $primary_selection_messages[] = "Primary image updated.";
                    } else {
                        $primary_selection_messages[] = "Selected primary image (ID: $newly_selected_primary_id) no longer exists. Primary image not changed from current.";
                        $primary_image_path_for_project_table = $current_primary_image_path_in_db;
                    }
                } else {
                    $primary_image_path_for_project_table = $current_primary_image_path_in_db;
                }
            } else {
                $old_primary_was_deleted = ($current_primary_id_in_db && isset($images_to_delete_ids) && in_array($current_primary_id_in_db, $images_to_delete_ids));
                
                if ($old_primary_was_deleted || $current_primary_id_in_db === null) {
                    $stmt_pick_first_remaining = $pdo->prepare("SELECT id, image_path FROM project_images WHERE project_id = :project_id ORDER BY id ASC LIMIT 1");
                    $stmt_pick_first_remaining->execute([':project_id' => $project_id]);
                    $first_remaining_image = $stmt_pick_first_remaining->fetch(PDO::FETCH_ASSOC);

                    if ($first_remaining_image) {
                        $pdo->prepare("UPDATE project_images SET is_primary = FALSE WHERE project_id = :project_id")->execute([':project_id' => $project_id]); // Clear any others (safety)
                        $pdo->prepare("UPDATE project_images SET is_primary = TRUE WHERE id = :id")->execute([':id' => $first_remaining_image['id']]);
                        $primary_image_path_for_project_table = $first_remaining_image['image_path'];
                        if($old_primary_was_deleted) $primary_selection_messages[] = "Previous primary image deleted. New primary automatically assigned.";
                        else $primary_selection_messages[] = "Primary image automatically assigned.";

                    } else {
                        $primary_image_path_for_project_table = null;
                        if($old_primary_was_deleted) $primary_selection_messages[] = "Primary image deleted. No other images available to set as new primary.";
                    }
                } else {
                    $primary_image_path_for_project_table = $current_primary_image_path_in_db;
                }
            }
            $stmt_update_main_img = $pdo->prepare("UPDATE projects SET image_path = :image_path WHERE id = :id");
            $stmt_update_main_img->execute([':image_path' => $primary_image_path_for_project_table, ':id' => $project_id]);

        } catch (PDOException $e){
            error_log("Error during primary image handling for project $project_id: " . $e->getMessage());
            $primary_selection_messages[] = "An error occurred while updating primary image status.";
        }

        $final_messages = [];
        if ($core_update_successful) {
            $final_messages[] = "project details updated.";
        }
        $final_messages = array_merge($final_messages, $image_deletion_messages, $image_upload_messages, $primary_selection_messages);

        if (!empty($final_messages)) {
            $_SESSION['message'] = implode("<br>", array_filter(array_map('sanitize_output', $final_messages)));
            $has_errors_in_messages = false;
            foreach($final_messages as $msg) {
                if (stripos($msg, 'fail') !== false || stripos($msg, 'error') !== false || stripos($msg, 'invalid') !== false || stripos($msg, 'could not') !== false) {
                    $has_errors_in_messages = true; break;
                }
            }
            if ($has_errors_in_messages) $_SESSION['message_type'] = "warning";
            elseif($core_update_successful || count(array_filter(array_merge($image_deletion_messages, $image_upload_messages, $primary_selection_messages))) > 0) $_SESSION['message_type'] = "success";
            else $_SESSION['message_type'] = "notice";
        } else {
            $_SESSION['message'] = "No changes were detected or an issue occurred.";
            $_SESSION['message_type'] = "notice";
        }

        header("Location: edit_project?id=" . $project_id);
        exit;

    } else {
        $_SESSION['message'] = "Invalid access to processing page.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_projects");
        exit;
    }
?>
