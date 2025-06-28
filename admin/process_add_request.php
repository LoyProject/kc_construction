<?php
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_requests");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_add_request'])) {
        $name = trim($_POST['name']);
        $tell = trim($_POST['tell']);
        $email = trim($_POST['email']);
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);

        $errors = [];
        if (empty($name)) $errors[] = "Name is required.";
        elseif (strlen($name) > 100) $errors[] = "Name cannot exceed 100 characters.";

        if (empty($tell)) $errors[] = "Telephone is required.";
        elseif (strlen($tell) > 30) $errors[] = "Telephone cannot exceed 30 characters.";

        if (empty($email)) $errors[] = "Email is required.";
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
        elseif (strlen($email) > 100) $errors[] = "Email cannot exceed 100 characters.";

        if (empty($subject)) $errors[] = "Subject is required.";
        elseif (strlen($subject) > 150) $errors[] = "Subject cannot exceed 150 characters.";

        if (empty($message)) $errors[] = "Message is required.";

        // Optionally, check for duplicate requests (e.g., same email & subject)
        /*
        if (!empty($email) && !empty($subject)) {
            try {
                $stmt_check = $pdo->prepare("SELECT id FROM requests WHERE email = :email AND subject = :subject");
                $stmt_check->bindParam(':email', $email);
                $stmt_check->bindParam(':subject', $subject);
                $stmt_check->execute();
                if ($stmt_check->fetch()) {
                    $errors[] = "A request with this email and subject already exists.";
                }
            } catch (PDOException $e) {
                error_log("Error checking duplicate request: " . $e->getMessage());
                $errors[] = "Database error checking for duplicate request.";
            }
        }
        */

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            $_SESSION['message'] = "Please correct the errors below.";
            $_SESSION['message_type'] = "error";
            header("Location: add_request");
            exit;
        }

        try {
            $sql = "INSERT INTO requests (name, tell, email, subject, message) VALUES (:name, :tell, :email, :subject, :message)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':tell', $tell);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':message', $message);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Request from '<span class=\"font-bold text-slate-700\">" . sanitize_output($name) . "</span>' added successfully!";
                $_SESSION['message_type'] = "success";
                header("Location: manage_requests");
                exit;
            } else {
                $_SESSION['message'] = "Failed to add request. Please try again.";
                $_SESSION['message_type'] = "error";
            }
        } catch (PDOException $e) {
            error_log("Database error on request insert: " . $e->getMessage());
            $_SESSION['message'] = "Database error: <span class=\"font-semibold\">" . sanitize_output($e->getMessage()) . "</span>";
            $_SESSION['message_type'] = "error";
            $_SESSION['form_data'] = $_POST;
        }
        header("Location: add_request");
        exit;
    } else {
        $_SESSION['message'] = "Invalid access to processing page.";
        $_SESSION['message_type'] = "error";
        header("Location: add_request");
        exit;
    }
?>
