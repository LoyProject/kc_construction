<?php
    require_once(__DIR__ . '/../admin/includes/db_connect.php');

    header('Content-Type: application/json');

    $sql = "SELECT id, name, description, created_at FROM floors ORDER BY id ASC";
    $stmt = $pdo->query($sql);

    $floors = [];
    while ($row = $stmt->fetch()) {
        $floors[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'created_at' => $row['created_at']
        ];
    }

    if (!empty($floors)) {
        $response = [
            'success' => true,
            'floors' => $floors
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'No Floors Found'
        ];
    }

    echo json_encode($response);
?>
