<?php
    session_start();
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_change_password'])) {
        $user_id = $_SESSION['temp_user_id'] ?? 0;
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        $errors = [];

        if ($user_id <= 0) {
            $errors[] = "Invalid user session.";
        }

        if (empty($current_password)) {
            $errors[] = "Current password is required.";
        }

        if (empty($new_password)) {
            $errors[] = "New password is required.";
        } elseif (strlen($new_password) < 6) {
            $errors[] = "New password must be at least 6 characters long.";
        }

        if ($new_password !== $confirm_password) {
            $errors[] = "New passwords do not match.";
        }

        if ($new_password === '123456' || $confirm_password === '123456') {
            $errors[] = "Password cannot be '123456'. Please choose a more secure password.";
        }

        if (empty($errors)) {
            $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = :id");
            $stmt->execute([':id' => $user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($current_password, $user['password_hash'])) {
                $errors[] = "Current password is incorrect.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header("Location: change_password");
            exit;
        }

        try {
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password_hash = :password_hash WHERE id = :id";
            $params = [
                ':password_hash' => $password_hash,
                ':id' => $user_id
            ];

            $stmt_update = $pdo->prepare($sql);

            if ($stmt_update->execute($params)) {
                $_SESSION['message'] = "Password changed successfully!";
                $_SESSION['message_type'] = "success";

                unset($_SESSION['temp_user_id']);
                
                $stmt = $pdo->prepare("SELECT id, username, role FROM users WHERE id = :id");
                $stmt->execute([':id' => $user_id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$user) {
                    $_SESSION['message'] = "User not found.";
                    $_SESSION['message_type'] = "error";
                    header("Location: change_password");
                    exit;
                }
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                session_write_close();
                
                header("Location: index");
                exit;
            } else {
                $_SESSION['message'] = "Failed to change password. Please try again.";
                $_SESSION['message_type'] = "error";
            }
        } catch (PDOException $e) {
            error_log("Database error on password change: " . $e->getMessage());
            $_SESSION['message'] = "A database error occurred during password change.";
            $_SESSION['message_type'] = "error";
        }

        $_SESSION['form_data'] = $_POST;
        header("Location: change_password");
        exit;
    } else {
        header("Location: change_password");
        exit;
    }
?>
