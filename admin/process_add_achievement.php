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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_add_achievement'])) {
        $title = trim($_POST['title']);
        $subtitle = trim($_POST['subtitle']);

        $errors = [];
        if (empty($title)) $errors[] = "Title is required.";

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            $_SESSION['message'] = "Please correct the errors below.";
            $_SESSION['message_type'] = "error";
            header("Location: add_achievement");
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO achievements (title, subtitle) VALUES (:title, :subtitle)");
            $stmt->execute([':title' => $title, ':subtitle' => $subtitle]);
            $achievement_id = $pdo->lastInsertId();

            for ($i = 1; $i <= 3; $i++) {
                $item_name = trim($_POST["achievement_name_$i"]) ?? null;
                $item_description = trim($_POST["achievement_description_$i"]) ?? null;
                $item_image_path = null;

                if (!empty($_FILES["achievement_image_$i"]["name"])) {
                    $tmp = $_FILES["achievement_image_$i"]["tmp_name"];
                    $ext = strtolower(pathinfo($_FILES["achievement_image_$i"]["name"], PATHINFO_EXTENSION));
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                    $max_size = 20 * 1024 * 1024;

                    if (in_array($ext, $allowed) && $_FILES["achievement_image_$i"]["size"] <= $max_size) {
                        $target_dir = "assets/images/achievements/";
                        $file_name = uniqid("achv_$achievement_id"."_", true) . ".$ext";
                        $file_path = $target_dir . $file_name;

                        if (move_uploaded_file($tmp, $file_path)) {
                            $item_image_path = $file_path;
                        }
                    }
                }

                if ($item_name || $item_description || $item_image_path) {
                    $stmt_item = $pdo->prepare("INSERT INTO achievement_items (achievement_id, name, description, image) VALUES (:achievement_id, :name, :description, :image_path)");
                    $stmt_item->execute([
                        ':achievement_id' => $achievement_id,
                        ':name' => $item_name,
                        ':description' => $item_description,
                        ':image_path' => $item_image_path
                    ]);
                }
            }

            $slideshow_dir = "assets/images/slideshow/";
            if (!empty($_FILES['slideshow_images']['name'][0])) {
                foreach ($_FILES['slideshow_images']['tmp_name'] as $index => $tmp) {
                    $original = $_FILES['slideshow_images']['name'][$index];
                    $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
                    $size = $_FILES['slideshow_images']['size'][$index];

                    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif']) || $size > 20 * 1024 * 1024) {
                        continue;
                    }

                    $file_name = uniqid("slide_$achievement_id"."_", true) . ".$ext";
                    $file_path = $slideshow_dir . $file_name;

                    if (move_uploaded_file($tmp, $file_path)) {
                        $stmt_slide = $pdo->prepare("INSERT INTO slideshow (achievement_id, image_path, uploaded_at) VALUES (:achievement_id, :image_path, NOW())");
                        $stmt_slide->execute([
                            ':achievement_id' => $achievement_id,
                            ':image_path' => $file_path
                        ]);
                    }
                }
            }

            $_SESSION['message'] = "Achievement and related items added successfully.";
            $_SESSION['message_type'] = "success";
            header("Location: manage_achievements");
            exit;

        } catch (PDOException $e) {
            error_log("DB error: " . $e->getMessage());
            $_SESSION['message'] = "Database error occurred.";
            $_SESSION['message_type'] = "error";
            $_SESSION['form_data'] = $_POST;
            header("Location: add_achievement");
            exit;
        }
    } else {
        $_SESSION['message'] = "Invalid access.";
        $_SESSION['message_type'] = "error";
        header("Location: add_achievement");
        exit;
    }
?>
