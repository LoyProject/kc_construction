<?php
    require_once(__DIR__ . '/../admin/includes/db_connect.php');

    header('Content-Type: application/json');

    $sql = "SELECT id, name, description, created_at FROM facades ORDER BY id ASC";
    $stmt = $pdo->query($sql);

    $facades = [];
    while ($row = $stmt->fetch()) {
        $facades[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'created_at' => $row['created_at']
        ];
    }

    if (!empty($facades)) {
        $response = [
            'success' => true,
            'facades' => $facades
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'No Facades Found'
        ];
    }

    echo json_encode($response);
?>
