<?php
    require_once 'db_connect.php';

    $achievement_id = isset($_GET['achievement_id']) ? (int)$_GET['achievement_id'] : 2;

    try {
        $stmt = $pdo->prepare(
            "SELECT id, achievement_id, image_path, uploaded_at 
            FROM slideshow 
            WHERE achievement_id = :achievement_id 
            ORDER BY id ASC"
        );
        $stmt->bindParam(':achievement_id', $achievement_id, PDO::PARAM_INT);
        $stmt->execute();
        $slides = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($slides ?: []);
    } catch (PDOException $e) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Database error']);
    }
?>
