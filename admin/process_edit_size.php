<?php
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_sizes");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_edit_size'])) {
        $size_id = filter_input(INPUT_POST, 'size_id', FILTER_VALIDATE_INT);
        $name = trim($_POST['name']);
        $description = trim($_POST['description']) ?: null;

        $errors = [];
        if (!$size_id) $errors[] = "Invalid size ID.";
        if (empty($name)) $errors[] = "Size name is required.";
        elseif (strlen($name) > 100) $errors[] = "Size name cannot exceed 100 characters.";

        if (!empty($name) && $size_id) {
            try {
                $stmt_check = $pdo->prepare("SELECT id FROM sizes WHERE name = :name AND id != :id");
                $stmt_check->bindParam(':name', $name);
                $stmt_check->bindParam(':id', $size_id, PDO::PARAM_INT);
                $stmt_check->execute();
                if ($stmt_check->fetch()) {
                    $errors[] = "A size with this name (<span class=\"font-bold text-slate-700\">" . sanitize_output($name) . "</span>) already exists.";
                }
            } catch (PDOException $e) {
                error_log("Error checking duplicate size on edit: " . $e->getMessage());
                $errors[] = "Database error checking for duplicate size name.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            $_SESSION['message'] = "Please correct the errors below.";
            $_SESSION['message_type'] = "error";
            header("Location: edit_size?id=" . $size_id);
            exit;
        }

        try {
            $sql = "UPDATE sizes SET name = :name, description = :description WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':id', $size_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Size '<span class=\"font-bold text-slate-700\">" . sanitize_output($name) . "</span>' updated successfully!";
                $_SESSION['message_type'] = "success";
                header("Location: manage_sizes");
                exit;
            } else {
                $_SESSION['message'] = "Failed to update size. Please try again.";
                $_SESSION['message_type'] = "error";
            }
        } catch (PDOException $e) {
            error_log("Database error on size update: " . $e->getMessage());
            $_SESSION['message'] = "Database error updating size: <span class=\"font-semibold\">" . sanitize_output($e->getMessage()) . "</span>";
            $_SESSION['message_type'] = "error";
        }
        header("Location: edit_size?id=" . $size_id);
        exit;
    } else {
        $_SESSION['message'] = "Invalid access to processing page.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_sizes");
        exit;
    }
?>
