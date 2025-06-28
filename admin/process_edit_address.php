<?php
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_addresses");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_edit_address'])) {
        $address_id = filter_input(INPUT_POST, 'address_id', FILTER_VALIDATE_INT);
        $name = trim($_POST['name']);
        $description = trim($_POST['description']) ?: null;

        $errors = [];
        if (!$address_id) $errors[] = "Invalid address ID.";
        if (empty($name)) $errors[] = "Address name is required.";
        elseif (strlen($name) > 100) $errors[] = "Address name cannot exceed 100 characters.";

        if (!empty($name) && $address_id) {
            try {
                $stmt_check = $pdo->prepare("SELECT id FROM addresses WHERE name = :name AND id != :id");
                $stmt_check->bindParam(':name', $name);
                $stmt_check->bindParam(':id', $address_id, PDO::PARAM_INT);
                $stmt_check->execute();
                if ($stmt_check->fetch()) {
                    $errors[] = "An address with this name (<span class=\"font-bold text-slate-700\">" . sanitize_output($name) . "</span>) already exists.";
                }
            } catch (PDOException $e) {
                error_log("Error checking duplicate address on edit: " . $e->getMessage());
                $errors[] = "Database error checking for duplicate address name.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            $_SESSION['message'] = "Please correct the errors below.";
            $_SESSION['message_type'] = "error";
            header("Location: edit_address?id=" . $address_id);
            exit;
        }

        try {
            $sql = "UPDATE addresses SET name = :name, description = :description WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':id', $address_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Address '<span class=\"font-bold text-slate-700\">" . sanitize_output($name) . "</span>' updated successfully!";
                $_SESSION['message_type'] = "success";
                header("Location: manage_addresses");
                exit;
            } else {
                $_SESSION['message'] = "Failed to update address. Please try again.";
                $_SESSION['message_type'] = "error";
            }
        } catch (PDOException $e) {
            error_log("Database error on address update: " . $e->getMessage());
            $_SESSION['message'] = "Database error updating address: <span class=\"font-semibold\">" . sanitize_output($e->getMessage()) . "</span>";
            $_SESSION['message_type'] = "error";
        }
        header("Location: edit_address?id=" . $address_id);
        exit;
    } else {
        $_SESSION['message'] = "Invalid access to processing page.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_addresses");
        exit;
    }
?>
