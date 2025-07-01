<?php
    require_once(__DIR__ . '/../admin/includes/db_connect.php');

    header('Content-Type: application/json');

    $sql = "SELECT id, name, description, created_at FROM areas ORDER BY id ASC";
    $stmt = $pdo->query($sql);

    $areas = [];
    while ($row = $stmt->fetch()) {
        $areas[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'created_at' => $row['created_at']
        ];
    }

    if (!empty($areas)) {
        $response = [
            'success' => true,
            'areas' => $areas
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'No Areas Found'
        ];
    }

    echo json_encode($response);
?>
