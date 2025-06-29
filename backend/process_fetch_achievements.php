<?php
    require_once(__DIR__ . '/../admin/includes/db_connect.php');

    header('Content-Type: application/json');

    try {
        $sql = "SELECT id, title, subtitle, created_at FROM achievements ORDER BY id ASC LIMIT 1";
        $stmt = $pdo->query($sql);
        $achievement = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($achievement) {
            $achievement_id = $achievement['id'];

            $sql = "SELECT id, image_path, uploaded_at FROM slideshow WHERE achievement_id = :achievement_id ORDER BY id ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['achievement_id' => $achievement_id]);
            $slides = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $sql = "SELECT id, name, description, image, created_at FROM achievement_items WHERE achievement_id = :achievement_id ORDER BY id ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['achievement_id' => $achievement_id]);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = [
                'success' => true,
                'achievement' => $achievement,
                'slideshow' => $slides,
                'achievement_items' => $items
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No achievement found.'
            ];
        }
    } catch (PDOException $e) {
        $response = [
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ];
    }

    echo json_encode($response);
?>
