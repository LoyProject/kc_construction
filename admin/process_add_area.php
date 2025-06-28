<?php
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_areas");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_add_area'])) {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']) ?: null;

        $errors = [];
        if (empty($name))  $errors[] = "Area name is required.";
        elseif (strlen($name) > 100) $errors[] = "Area name cannot exceed 100 characters.";
        
        if (!empty($name)) {
            try {
                $stmt_check = $pdo->prepare("SELECT id FROM areas WHERE name = :name");
                $stmt_check->bindParam(':name', $name);
                $stmt_check->execute();
                if ($stmt_check->fetch()) {
                    $errors[] = "An area with this name (<span class=\"font-bold text-slate-700\">" . sanitize_output($name) . "</span>) already exists.";
                }
            } catch (PDOException $e) {
                error_log("Error checking duplicate area: " . $e->getMessage());
                $errors[] = "Database error checking for duplicate area name.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            $_SESSION['message'] = "Please correct the errors below.";
            $_SESSION['message_type'] = "error";
            header("Location: add_area");
            exit;
        }

        try {
            $sql = "INSERT INTO areas (name, description) VALUES (:name, :description)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Area '<span class=\"font-bold text-slate-700\">" . sanitize_output($name) . "</span>' added successfully!";
                $_SESSION['message_type'] = "success";
                header("Location: manage_areas");
                exit;
            } else {
                $_SESSION['message'] = "Failed to add area. Please try again.";
                $_SESSION['message_type'] = "error";
            }
        } catch (PDOException $e) {
            error_log("Database error on area insert: " . $e->getMessage());
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $_SESSION['message'] = "Error: An area with this name (<span class=\"font-bold text-slate-700\">" . sanitize_output($name) . "</span>) already exists.";
            } else {
                $_SESSION['message'] = "Database error: <span class=\"font-semibold\">" . sanitize_output($e->getMessage()) . "</span>";
            }
            $_SESSION['message_type'] = "error";
            $_SESSION['form_data'] = $_POST;
        }
        header("Location: add_area");
        exit;
    } else {
        $_SESSION['message'] = "Invalid access to processing page.";
        $_SESSION['message_type'] = "error";
        header("Location: add_area");
        exit;
    }
?>
