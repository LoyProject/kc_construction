<?php
    session_start();
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_login'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $_SESSION['message'] = "Username and password are required.";
            $_SESSION['message_type'] = "error";
            header("Location: login");
            exit;
        }

        try {
            $stmt = $pdo->prepare("SELECT id, username, password_hash, role FROM users WHERE username = :username AND status = 'Active'");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                if ($password === '123456') {
                    $_SESSION['temp_user_id'] = $user['id'];
                    header("Location: change_password");
                    exit;
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    
                    session_write_close();
                    
                    header("Location: index");
                    exit;
                }
            } else {
                $_SESSION['message'] = "Invalid username or password.";
                $_SESSION['message_type'] = "error";
                header("Location: login");
                exit;
            }

        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            $_SESSION['message'] = "A database error occurred. Please try again.";
            $_SESSION['message_type'] = "error";
            header("Location: login");
            exit;
        }
    } else {
        header("Location: login");
        exit;
    }
?>
