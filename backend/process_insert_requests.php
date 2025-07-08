<?php
    require_once(__DIR__ . '/../admin/includes/db_connect.php');

    header('Content-Type: application/json');

    $name = $_POST['name'] ?? '';
    $tell = $_POST['tell'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO requests (name, tell, email, subject, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $tell, $email, $subject, $message]);
            echo json_encode(['status' => 'success', 'message' => 'Request submitted successfully.']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to submit request: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
    }
?>
