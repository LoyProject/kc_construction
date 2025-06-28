<?php
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_achievements");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_edit_achievement'])) {
        $achievement_id = (int)$_POST['id'];
        $title = trim($_POST['title']);
        $subtitle = trim($_POST['subtitle']);

        $errors = [];
        if (!$title) $errors[] = "Title is required.";
        if (!$subtitle) $errors[] = "Subtitle is required.";

        if ($errors) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            $_SESSION['message'] = "Please correct the errors below.";
            $_SESSION['message_type'] = "error";
            header("Location: edit_achievement?id=$achievement_id");
            exit;
        }

        try {
            $pdo->prepare("UPDATE achievements SET title = :title, subtitle = :subtitle WHERE id = :id")
                ->execute([':title' => $title, ':subtitle' => $subtitle, ':id' => $achievement_id]);

            $items_stmt = $pdo->prepare("SELECT * FROM achievement_items WHERE achievement_id = :achievement_id ORDER BY id ASC");
            $items_stmt->execute([':achievement_id' => $achievement_id]);
            $achievement_items = $items_stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($achievement_items as $index => $item) {
                $i = $index + 1;
                $item_id = $item['id'];
                $item_name = trim($_POST["achievement_name_$i"] ?? '');
                $item_description = trim($_POST["achievement_description_$i"] ?? '');

                $pdo->prepare("UPDATE achievement_items SET name = :name, description = :description WHERE id = :id")
                    ->execute([':name' => $item_name, ':description' => $item_description, ':id' => $item_id]);

                $image_field = $_FILES["achievement_image_$i"] ?? null;
                if ($image_field && $image_field['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($image_field['name'], PATHINFO_EXTENSION));
                    $file_name = uniqid("achv_$achievement_id" . "_", true) . "." . $ext;
                    $image_path = 'assets/images/achievements/' . $file_name;

                    if (move_uploaded_file($image_field['tmp_name'], $image_path)) {
                        $pdo->prepare("UPDATE achievement_items SET image = :image WHERE id = :id")
                            ->execute([':image' => $image_path, ':id' => $item_id]);

                        if (!empty($item['image']) && file_exists($item['image'])) {
                            unlink($item['image']);
                        }
                    }
                }
            }

            if (!empty($_FILES['slideshow_images']['name'][0])) {
                foreach ($_FILES['slideshow_images']['name'] as $key => $name) {
                    if ($_FILES['slideshow_images']['error'][$key] === UPLOAD_ERR_OK) {
                        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                        $file_name = uniqid("slide_$achievement_id" . "_", true) . "." . $ext;
                        $file_path = 'assets/images/slideshow/' . $file_name;
                        if (move_uploaded_file($_FILES['slideshow_images']['tmp_name'][$key], $file_path)) {
                            $pdo->prepare("INSERT INTO slideshow (achievement_id, image_path) VALUES (:achievement_id, :image_path)")
                                ->execute([':achievement_id' => $achievement_id, ':image_path' => $file_path]);
                        }
                    }
                }
            }

            $deletion_msgs = [];
            if (!empty($_POST['delete_images']) && is_array($_POST['delete_images'])) {
                foreach ($_POST['delete_images'] as $image_id) {
                    $img_stmt = $pdo->prepare("SELECT image_path FROM slideshow WHERE id = :id AND achievement_id = :achievement_id");
                    $img_stmt->execute([':id' => $image_id, ':achievement_id' => $achievement_id]);
                    $img = $img_stmt->fetch(PDO::FETCH_ASSOC);

                    if ($img && file_exists($img['image_path'])) {
                        unlink($img['image_path']);
                        $pdo->prepare("DELETE FROM slideshow WHERE id = :id AND achievement_id = :achievement_id")
                            ->execute([':id' => $image_id, ':achievement_id' => $achievement_id]);
                        $deletion_msgs[] = "Image ID $image_id deleted successfully.";
                    } else {
                        $deletion_msgs[] = "Image ID $image_id not found or already deleted.";
                    }
                }
            }

            $_SESSION['message'] = "Achievement and related items updated successfully.";
            $_SESSION['message_type'] = "success";
            header("Location: manage_achievements");
            exit;

        } catch (PDOException $e) {
            error_log("DB error: " . $e->getMessage());
            $_SESSION['message'] = "Database error occurred.";
            $_SESSION['message_type'] = "error";
            $_SESSION['form_data'] = $_POST;
            header("Location: edit_achievement?id=$achievement_id");
            exit;
        }
    } else {
        $_SESSION['message'] = "Invalid access.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_achievements");
        exit;
    }
?>
