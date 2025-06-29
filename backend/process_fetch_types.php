<?php
    require_once(__DIR__ . '/../admin/includes/db_connect.php');

    header('Content-Type: application/json');

    $sql = "SELECT id, name, description, created_at FROM types ORDER BY id ASC";
    $stmt = $pdo->query($sql);

    $types = [];
    while ($row = $stmt->fetch()) {
        $types[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'created_at' => $row['created_at']
        ];
    }

    if (!empty($types)) {
        $response = [
            'success' => true,
            'types' => $types
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'No Types Found'
        ];
    }

    echo json_encode($response);
?>
