<?php
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_users");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_edit_user'])) {
        $user_id = intval($_POST['user_id'] ?? 0);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $role = $_POST['role'] ?? 'View';
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        $errors = [];

        if ($user_id <= 0) {
            $errors[] = "Invalid user ID.";
        }

        if (empty($username)) {
            $errors[] = "Username is required.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            $errors[] = "Username must be 3-20 characters long and can only contain letters, numbers, and underscores.";
        }

        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        $change_password = false;
        if (!empty($password) || !empty($password_confirm)) {
            $change_password = true;
            if (strlen($password) < 6) {
                $errors[] = "Password must be at least 6 characters long.";
            }
            if ($password !== $password_confirm) {
                $errors[] = "Passwords do not match.";
            }
        }

        if (empty($errors)) {
            try {
                $stmt_check = $pdo->prepare("SELECT id FROM users WHERE (username = :username OR email = :email) AND id != :id");
                $stmt_check->execute([':username' => $username, ':email' => $email, ':id' => $user_id]);
                if ($stmt_check->fetch()) {
                    $errors[] = "Username or email already exists.";
                }
            } catch (PDOException $e) {
                error_log("Error checking user existence: " . $e->getMessage());
                $errors[] = "A database error occurred. Please try again.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header("Location: edit_user?id=" . urlencode($user_id));
            exit;
        }

        try {
            if ($change_password) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET username = :username, email = :email, role = :role, password_hash = :password_hash WHERE id = :id";
                $params = [
                    ':username' => $username,
                    ':email' => $email,
                    ':role' => $role,
                    ':password_hash' => $password_hash,
                    ':id' => $user_id
                ];
            } else {
                $sql = "UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id";
                $params = [
                    ':username' => $username,
                    ':email' => $email,
                    ':role' => $role,
                    ':id' => $user_id
                ];
            }

            $stmt_update = $pdo->prepare($sql);

            if ($stmt_update->execute($params)) {
                $_SESSION['message'] = "User '<span class=\"font-bold text-slate-700\">" . sanitize_output($username) . "</span>' updated successfully!";
                $_SESSION['message_type'] = "success";
                header("Location: manage_users");
                exit;
            } else {
                $_SESSION['message'] = "Failed to update User. Please try again.";
                $_SESSION['message_type'] = "error";
            }
        } catch (PDOException $e) {
            error_log("Database error on user update: " . $e->getMessage());
            $_SESSION['message'] = "A database error occurred during update.";
            $_SESSION['message_type'] = "error";
        }

        $_SESSION['form_data'] = $_POST;
        header("Location: edit_user?id=" . urlencode($user_id));
        exit;
    } else {
        header("Location: manage_users");
        exit;
    }
?>
