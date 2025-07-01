<?php
    require_once(__DIR__ . '/../admin/includes/db_connect.php');

    header('Content-Type: application/json');

    $sql = "SELECT id, name, description, created_at FROM styles ORDER BY id ASC";
    $stmt = $pdo->query($sql);

    $styles = [];
    while ($row = $stmt->fetch()) {
        $styles[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'created_at' => $row['created_at']
        ];
    }

    if (!empty($styles)) {
        $response = [
            'success' => true,
            'styles' => $styles
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'No Styles Found'
        ];
    }

    echo json_encode($response);
?>
