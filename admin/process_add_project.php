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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_add_project'])) {
        $errors = [];
        if (empty($_POST['name']))
            $errors[] = "Project name is required.";
        if (empty($_POST['style_id']) || !filter_var($_POST['style_id'], FILTER_VALIDATE_INT))
            $errors[] = "Please select a valid style.";
        if (empty($_POST['type_id']) || !filter_var($_POST['type_id'], FILTER_VALIDATE_INT))
            $errors[] = "Please select a valid type.";
        if (empty($_POST['floor_id']) || !filter_var($_POST['floor_id'], FILTER_VALIDATE_INT))
            $errors[] = "Please select a valid number of floors.";
        // if (empty($_POST['facade_id']) || !filter_var($_POST['facade_id'], FILTER_VALIDATE_INT))
        //     $errors[] = "Please select a valid facade.";
        if (empty($_POST['facade']))
            $core_errors[] = "Facade is required.";
        // if (empty($_POST['area_id']) || !filter_var($_POST['area_id'], FILTER_VALIDATE_INT))
        //     $errors[] = "Please select a valid area.";
        if (empty($_POST['area']))
            $core_errors[] = "Area is required.";
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $uploaded_files_check = $_FILES['images'];
            $max_file_size = 3 * 1024 * 1024; // 3MB
            for ($i = 0; $i < count($uploaded_files_check['name']); $i++) {
                if (empty($uploaded_files_check['name'][$i])) { continue; }
                if ($uploaded_files_check['error'][$i] == UPLOAD_ERR_OK) {
                    $file_size_check = $uploaded_files_check['size'][$i];
                    if ($file_size_check > $max_file_size) {
                        $errors[] = "File '".sanitize_output(basename($uploaded_files_check['name'][$i]))."': Too large (max 3MB).";
                    }
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
        $video = trim($_POST['video']) ?: null;
        $detail_floor = trim($_POST['detail_floor']) ?: null;
        $detail_area = trim($_POST['detail_area']) ?: null;

        $image_validation_errors = [];
        $at_least_one_valid_image_provided = false;

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $uploaded_files_check = $_FILES['images'];
            for ($i = 0; $i < count($uploaded_files_check['name']); $i++) {
                if (empty($uploaded_files_check['name'][$i])) { continue; }
                if ($uploaded_files_check['error'][$i] == UPLOAD_ERR_OK) {
                    $original_name_check = basename($uploaded_files_check['name'][$i]);
                    $file_size_check = $uploaded_files_check['size'][$i];
                    $image_file_type_check = strtolower(pathinfo($original_name_check, PATHINFO_EXTENSION));
                    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                    $max_file_size = 3 * 1024 * 1024;
                    if (!in_array($image_file_type_check, $allowed_types)) {
                        $image_validation_errors[] = "File '".sanitize_output($original_name_check)."': Invalid type (JPG, JPEG, PNG, GIF only)."; continue;
                    }
                    if ($file_size_check == 0) {
                        $image_validation_errors[] = "File '".sanitize_output($original_name_check)."': File is empty."; continue;
                    }
                    if ($file_size_check > $max_file_size) {
                        $image_validation_errors[] = "File '".sanitize_output($original_name_check)."': Too large (max 3MB)."; continue;
                    }
                    $at_least_one_valid_image_provided = true;
                    break; 
                
                } elseif ($uploaded_files_check['error'][$i] != UPLOAD_ERR_NO_FILE) {
                    $image_validation_errors[] = "Error with file '".sanitize_output(basename($uploaded_files_check['name'][$i]))."': Upload error code " . $uploaded_files_check['error'][$i] . ".";
                }
            }
        }
        
        if (!$at_least_one_valid_image_provided) {
            if (empty($image_validation_errors)) {
                $errors[] = "At least one project image is required.";
            }
        }

        if (!empty($image_validation_errors)) {
            $errors = array_merge($errors, $image_validation_errors);
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            $_SESSION['message'] = "Please correct the errors below.";
            $_SESSION['message_type'] = "error";
            header("Location: add_project");
            exit;
        }

        $new_project_id = null;
        try {
            // $sql_insert_project = "INSERT INTO projects (name, style_id, type_id, floor_id, facade_id, area_id, size_id, view, investor, address_id, implement_at, implement_unit, budget, detail_floor, detail_area, video) 
            //                         VALUES (:name, :style_id, :type_id, :floor_id, :facade_id, :area_id, :size_id, :view, :investor, :address_id, :implement_at, :implement_unit, :budget, :detail_floor, :detail_area, :video)";
            $sql_insert_project = "INSERT INTO projects (name, style_id, type_id, floor_id, facade, area, size, view, investor, address, implement_at, implement_unit, budget, detail_floor, detail_area, video)
                        VALUES (:name, :style_id, :type_id, :floor_id, :facade, :area, :size, :view, :investor, :address, :implement_at, :implement_unit, :budget, :detail_floor, :detail_area, :video)";

            $stmt_insert_project = $pdo->prepare($sql_insert_project);
            $stmt_insert_project->bindParam(':name', $name);
            $stmt_insert_project->bindParam(':style_id', $style_id, PDO::PARAM_INT);
            $stmt_insert_project->bindParam(':type_id', $type_id, PDO::PARAM_INT);
            $stmt_insert_project->bindParam(':floor_id', $floor_id, PDO::PARAM_INT);
            // $stmt_insert_project->bindParam(':facade_id', $facade_id, PDO::PARAM_INT);
            $stmt_insert_project->bindParam(':facade', $facade);
            // $stmt_insert_project->bindParam(':area_id', $area_id, PDO::PARAM_INT);
            $stmt_insert_project->bindParam(':area', $area);
            // $stmt_insert_project->bindParam(':size_id', $size_id, PDO::PARAM_INT);
            $stmt_insert_project->bindParam(':size', $size);
            $stmt_insert_project->bindParam(':view', $view, PDO::PARAM_INT);
            $stmt_insert_project->bindParam(':investor', $investor);
            // $stmt_insert_project->bindParam(':address_id', $address_id, PDO::PARAM_INT);
            $stmt_insert_project->bindParam(':address', $address);
            $stmt_insert_project->bindParam(':implement_at', $implement_at, PDO::PARAM_INT);
            $stmt_insert_project->bindParam(':implement_unit', $implement_unit);
            $stmt_insert_project->bindParam(':budget', $budget);
            $stmt_insert_project->bindParam(':detail_floor', $detail_floor);
            $stmt_insert_project->bindParam(':detail_area', $detail_area);
            $stmt_insert_project->bindParam(':video', $video);

            if ($stmt_insert_project->execute()) {
                $new_project_id = $pdo->lastInsertId();
            } else {
                $_SESSION['message'] = "Failed to add project core details.";
                $_SESSION['message_type'] = "error";
                $_SESSION['form_data'] = $_POST;
                header("Location: add_project");
                exit;
            }
        } catch (PDOException $e) {
            error_log("Database error on project insert: " . $e->getMessage());
            $_SESSION['message'] = "Database error occurred while adding project: <span class=\"font-semibold\">" . sanitize_output($e->getMessage()) . "</span>";
            $_SESSION['message_type'] = "error";
            $_SESSION['form_data'] = $_POST;
            header("Location: add_project");
            exit;
        }

        $image_processing_messages = [];
        $first_image_path_for_primary = null; 

        if ($new_project_id && isset($_FILES['images'])) {
            $uploaded_files = $_FILES['images'];
            $target_dir = "assets/images/projects/";

            for ($i = 0; $i < count($uploaded_files['name']); $i++) {
                if ($uploaded_files['error'][$i] == UPLOAD_ERR_OK) {
                    $tmp_name = $uploaded_files['tmp_name'][$i];
                    $original_name = basename($uploaded_files['name'][$i]);
                    $file_size = $uploaded_files['size'][$i];
                    
                    $image_file_type = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
                    $new_file_name = uniqid('proj_' . $new_project_id . '_', true) . '.' . $image_file_type;
                    $target_file_path = $target_dir . $new_file_name;

                    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                    $max_file_size = 3 * 1024 * 1024;

                    if (!in_array($image_file_type, $allowed_types)) {
                        $image_processing_messages[] = "File '".sanitize_output($original_name)."': Invalid type (skipped).";
                        continue;
                    }
                    if ($file_size == 0) {
                        $image_processing_messages[] = "File '".sanitize_output($original_name)."': File is empty (skipped).";
                        continue;
                    }
                    if ($file_size > $max_file_size) {
                        $image_processing_messages[] = "File '".sanitize_output($original_name)."': Too large (skipped).";
                        continue;
                    }

                    if (move_uploaded_file($tmp_name, $target_file_path)) {
                        try {
                            $is_primary = false;
                            if ($first_image_path_for_primary === null) {
                                $first_image_path_for_primary = $target_file_path;
                                $is_primary = true;
                            }

                            $stmt_insert_image = $pdo->prepare("INSERT INTO project_images (project_id, image_path, is_primary) VALUES (:project_id, :image_path, :is_primary)");
                            $stmt_insert_image->execute([
                                ':project_id' => $new_project_id,
                                ':image_path' => $target_file_path,
                                ':is_primary' => $is_primary ? 1 : 0
                            ]);
                            $image_processing_messages[] = "Image '".sanitize_output($original_name)."' uploaded.";
                        } catch (PDOException $e) {
                            error_log("DB Error inserting image ".$target_file_path.": " . $e->getMessage());
                            $image_processing_messages[] = "Image '".sanitize_output($original_name)."' uploaded but DB save failed.";
                            if(file_exists($target_file_path)) unlink($target_file_path);
                        }
                    } else {
                        $image_processing_messages[] = "Failed to upload '".sanitize_output($original_name)."'.";
                        error_log("Failed to move uploaded file: " . $original_name . " to " . $target_file_path);
                    }
                }
            }

            if ($first_image_path_for_primary && $new_project_id) {
                try {
                    $stmt_update_main_img = $pdo->prepare("UPDATE projects SET image_path = :image_path WHERE id = :id");
                    $stmt_update_main_img->execute([':image_path' => $first_image_path_for_primary, ':id' => $new_project_id]);
                } catch (PDOException $e) {
                    error_log("Error updating main image_path in projects table: " . $e->getMessage());
                    $image_processing_messages[] = "Note: Could not set main project image thumbnail.";
                }
            }
        }
        
        $final_message = "Project added successfully.";
        if (!empty($image_processing_messages)) {
            $final_message .= "<br>Image processing details:<br>" . implode("<br>", array_map('sanitize_output', $image_processing_messages));
        }
        $_SESSION['message'] = $final_message;
        $_SESSION['message_type'] = "success";

        header("Location: manage_projects");
        exit;
    } else {
        $_SESSION['message'] = "Invalid access to processing page.";
        $_SESSION['message_type'] = "error";
        header("Location: add_project");
        exit;
    }
?>
