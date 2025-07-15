<?php
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_companies");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_edit_company'])) {
        $company_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $name = trim($_POST['name']);
        $description = trim($_POST['description']) ?: null;
        $vision = trim($_POST['vision']) ?: null;
        $email = trim($_POST['email']) ?: null;
        $address = trim($_POST['address']) ?: null;
        $map = trim($_POST['map']) ?: null;
        $tell = trim($_POST['tell']) ?: null;
        $schedule = trim($_POST['schedule']) ?: null;
        $facebook = trim($_POST['facebook']) ?: null;
        $telegram = trim($_POST['telegram']) ?: null;
        $youtube = trim($_POST['youtube']) ?: null;
        $tiktok = trim($_POST['tiktok']) ?: null;

        $logo = null;
        $logo_sql = "";
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $uploaded_file = $_FILES['logo'];
            $target_dir = "assets/images/companies/";
            $original_name = basename($uploaded_file['name']);
            $tmp_name = $uploaded_file['tmp_name'];
            $file_size = $uploaded_file['size'];

            $image_file_type = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
            $new_file_name = uniqid('company_logo_', true) . '.' . $image_file_type;
            $target_file_path = $target_dir . $new_file_name;

            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            $max_file_size = 3 * 1024 * 1024; // 3MB

            if (!in_array($image_file_type, $allowed_types)) {
                $image_processing_messages[] = "Invalid image type. Only JPG, PNG, GIF allowed.";
            } elseif ($file_size == 0) {
                $image_processing_messages[] = "Image file is empty.";
            } elseif ($file_size > $max_file_size) {
                $image_processing_messages[] = "Image too large. Max allowed is 3MB.";
            } else {
                if (move_uploaded_file($tmp_name, $target_file_path)) {
                    $logo = $target_file_path;
                    $logo_sql = ", logo = :logo";
                    $image_processing_messages[] = "Logo image uploaded successfully.";

                    $stmt_check = $pdo->prepare("SELECT logo FROM companies WHERE id = :id");
                    $stmt_check->bindParam(':id', $company_id, PDO::PARAM_INT);
                    $stmt_check->execute();
                    $old_logo = $stmt_check->fetchColumn();
                    if ($old_logo && file_exists($old_logo)) {
                        unlink($old_logo);
                        $image_processing_messages[] = "Old logo image deleted successfully.";
                    }
                } else {
                    $image_processing_messages[] = "Failed to upload logo image.";
                    error_log("Failed to move uploaded file: " . $original_name . " to " . $target_file_path);
                }
            }
        }

        $errors = [];
        if (empty($name)) $errors[] = "Company name is required.";
        elseif (strlen($name) > 255) $errors[] = "Company name cannot exceed 255 characters.";

        if (!empty($name)) {
            try {
                $stmt_check = $pdo->prepare("SELECT name FROM companies WHERE id != :id");
                $stmt_check->bindParam(':id', $company_id, PDO::PARAM_INT);
                $stmt_check->execute();
                
                for ($existing_name = $stmt_check->fetchColumn(); $existing_name !== false; $existing_name = $stmt_check->fetchColumn()) {
                    if (strcasecmp($existing_name, $name) === 0) {
                        $errors[] = "A company with this name (<span class=\"font-bold text-slate-700\">" . sanitize_output($name) . "</span>) already exists.";
                        break;
                    }
                }
            } catch (PDOException $e) {
                error_log("Error checking duplicate company: " . $e->getMessage());
                $errors[] = "Database error checking for duplicate company name.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            $_SESSION['message'] = "Please correct the errors below.";
            $_SESSION['message_type'] = "error";
            header("Location: edit_company?id=" . $company_id);
            exit;
        }

        try {
            $sql = "UPDATE companies SET 
                name = :name, description = :description, vision = :vision, email = :email, address = :address, map = :map, tell = :tell,
                schedule = :schedule, facebook = :facebook, telegram = :telegram, youtube = :youtube, tiktok = :tiktok
                $logo_sql
                WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':vision', $vision);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':map', $map);
            $stmt->bindParam(':tell', $tell);
            $stmt->bindParam(':schedule', $schedule);
            $stmt->bindParam(':facebook', $facebook);
            $stmt->bindParam(':telegram', $telegram);
            $stmt->bindParam(':youtube', $youtube);
            $stmt->bindParam(':tiktok', $tiktok);
            if ($logo) $stmt->bindParam(':logo', $logo);
            $stmt->bindParam(':id', $company_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Company '<span class=\"font-bold text-slate-700\">" . sanitize_output($name) . "</span>' updated successfully!";
                $_SESSION['message_type'] = "success";
                header("Location: manage_companies");
                exit;
            } else {
                $_SESSION['message'] = "Failed to update company. Please try again.";
                $_SESSION['message_type'] = "error";
            }
        } catch (PDOException $e) {
            error_log("Database error on company update: " . $e->getMessage());
            $_SESSION['message'] = "Database error: <span class=\"font-semibold\">" . sanitize_output($e->getMessage()) . "</span>";
            $_SESSION['message_type'] = "error";
        }

        $_SESSION['form_data'] = $_POST;
        header("Location: edit_company?id=" . $company_id);
        exit;
    } else {
        $_SESSION['message'] = "Invalid access to processing page.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_companies");
        exit;
    }
?>
