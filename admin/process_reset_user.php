<?php
    require_once 'includes/admin_auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] !== 'Admin') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_users");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_reset_user'])) {
        $user_id = intval($_POST['user_id'] ?? 0);
        $password = $_POST['new_password'] ?? '';
        $password_confirm = $_POST['confirm_password'] ?? '';

        $errors = [];

        if ($user_id <= 0) {
            $errors[] = "Invalid user ID.";
        }

        if (empty($password)) {
            $errors[] = "Password is required.";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long.";
        }

        if ($password !== $password_confirm) {
            $errors[] = "Passwords do not match.";
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header("Location: reset_user?id=" . urlencode($user_id));
            exit;
        }

        try {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password_hash = :password_hash WHERE id = :id";
            $params = [
                ':password_hash' => $password_hash,
                ':id' => $user_id
            ];

            $stmt_update = $pdo->prepare($sql);

            if ($stmt_update->execute($params)) {
                $sql_log = "INSERT INTO reset_user (user_id, reset_by) VALUES (:user_id, :reset_by)";
                $params_log = [
                    ':user_id' => $user_id,
                    ':reset_by' => $_SESSION['user_id'] ?? 0
                ];
                $stmt_log = $pdo->prepare($sql_log);
                $stmt_log->execute($params_log);
                
                $_SESSION['message'] = "Password reset successfully!";
                $_SESSION['message_type'] = "success";
                header("Location: manage_users");
                exit;
            } else {
                $_SESSION['message'] = "Failed to reset password. Please try again.";
                $_SESSION['message_type'] = "error";
            }
        } catch (PDOException $e) {
            error_log("Database error on password reset: " . $e->getMessage());
            $_SESSION['message'] = "A database error occurred during password reset.";
            $_SESSION['message_type'] = "error";
        }

        $_SESSION['form_data'] = $_POST;
        header("Location: reset_user?id=" . urlencode($user_id));
        exit;
    } else {
        header("Location: manage_users");
        exit;
    }
?>
