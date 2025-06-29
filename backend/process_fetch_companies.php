<?php
    require_once(__DIR__ . '/../admin/includes/db_connect.php');

    header('Content-Type: application/json');

    $sql = "SELECT * FROM companies ORDER BY id ASC LIMIT 1";
    $stmt = $pdo->query($sql);

    if ($row = $stmt->fetch()) {
        $response = [
            'success' => true,
            'company' => [
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'vision' => $row['vision'],
                'email' => $row['email'],
                'address' => $row['address'],
                'map' => $row['map'],
                'tell' => $row['tell'],
                'schedule' => $row['schedule'],
                'facebook' => $row['facebook'],
                'telegram' => $row['telegram'],
                'instagram' => $row['instagram'],
                'youtube' => $row['youtube'],
                'linkedin' => $row['linkedin'],
                'logo' => 'admin/' . $row['logo'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
            ]
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'No Company Found'
        ];
    }

    echo json_encode($response);
?>