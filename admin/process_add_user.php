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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_add_user'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $role = $_POST['role'] ?? 'View';

        $errors = [];

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

        if (empty($password)) {
            $errors[] = "Password is required.";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long.";
        }

        if ($password !== $password_confirm) {
            $errors[] = "Passwords do not match.";
        }

        if (empty($errors)) {
            try {
                $stmt_check = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
                $stmt_check->execute([':username' => $username, ':email' => $email]);
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
            header("Location: add_user");
            exit;
        }

        try {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password_hash, role) VALUES (:username, :email, :password_hash, :role)";
            $stmt_insert = $pdo->prepare($sql);
            
            if ($stmt_insert->execute([
                ':username' => $username, 
                ':email' => $email, 
                ':password_hash' => $password_hash,
                ':role' => $role
            ])) {
                $_SESSION['message'] = "User '<span class=\"font-bold text-slate-700\">" . sanitize_output($username) . "</span>' added successfully!";
                $_SESSION['message_type'] = "success";
                header("Location: manage_users");
                exit;
            } else {
                $_SESSION['message'] = "Failed to add User. Please try again.";
                $_SESSION['message_type'] = "error";
            }
        } catch (PDOException $e) {
            error_log("Database error on user insert: " . $e->getMessage());
            $_SESSION['message'] = "A database error occurred during registration.";
            $_SESSION['message_type'] = "error";
        }

        $_SESSION['form_data'] = $_POST;
        header("Location: add_user");
        exit;
    } else {
        header("Location: add_user");
        exit;
    }
?>
