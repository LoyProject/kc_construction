<?php
    require_once(__DIR__ . '/../admin/includes/db_connect.php');

    header('Content-Type: application/json');

    if (!isset($_POST['id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Project ID is required'
        ]);
        exit;
    }

    $project_id = intval($_POST['id']);

    $updateSql = "UPDATE projects SET view = view + 1 WHERE id = ?";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute([$project_id]);

    $sql = "SELECT 
                p.id, 
                p.name, 
                p.style_id AS style, 
                p.type_id AS type, 
                p.floor_id AS floor, 
                p.facade_id AS facade, 
                p.area_id AS area, 
                p.size_id AS size, 
                p.address_id AS address, 
                p.view, 
                p.investor, 
                p.implement_at, 
                p.implement_unit, 
                p.detail_floor, 
                p.detail_area, 
                p.image_path, 
                p.video, 
                p.status, 
                p.created_at,
                s.name AS style_name, s.description AS style_description, s.created_at AS style_created_at,
                t.name AS type_name, t.description AS type_description, t.created_at AS type_created_at,
                f.name AS floor_name, f.description AS floor_description, f.created_at AS floor_created_at,
                fa.name AS facade_name, fa.description AS facade_description, fa.created_at AS facade_created_at,
                a.name AS area_name, a.description AS area_description, a.created_at AS area_created_at,
                sz.name AS size_name, sz.description AS size_description, sz.created_at AS size_created_at,
                ad.name AS address_name, ad.description AS address_description, ad.created_at AS address_created_at,
                pi.id AS image_id, pi.image_path AS project_image_path, pi.is_primary AS project_image_is_primary, pi.uploaded_at AS project_image_uploaded_at
            FROM projects p
            LEFT JOIN styles s ON p.style_id = s.id
            LEFT JOIN types t ON p.type_id = t.id
            LEFT JOIN floors f ON p.floor_id = f.id
            LEFT JOIN facades fa ON p.facade_id = fa.id
            LEFT JOIN areas a ON p.area_id = a.id
            LEFT JOIN sizes sz ON p.size_id = sz.id
            LEFT JOIN addresses ad ON p.address_id = ad.id
            LEFT JOIN project_images pi ON p.id = pi.project_id
            WHERE p.id = ?
            ORDER BY p.id ASC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$project_id]);

    if ($row = $stmt->fetch()) {
        $response = [
            'success' => true,
            'project' => [
                'id' => $row['id'],
                'name' => $row['name'],
                'style' => [
                    'id' => $row['style'],
                    'name' => $row['style_name'],
                    'description' => $row['style_description'],
                    'created_at' => $row['style_created_at']
                ],
                'type' => [
                    'id' => $row['type'],
                    'name' => $row['type_name'],
                    'description' => $row['type_description'],
                    'created_at' => $row['type_created_at']
                ],
                'floor' => [
                    'id' => $row['floor'],
                    'name' => $row['floor_name'],
                    'description' => $row['floor_description'],
                    'created_at' => $row['floor_created_at']
                ],
                'facade' => [
                    'id' => $row['facade'],
                    'name' => $row['facade_name'],
                    'description' => $row['facade_description'],
                    'created_at' => $row['facade_created_at']
                ],
                'area' => [
                    'id' => $row['area'],
                    'name' => $row['area_name'],
                    'description' => $row['area_description'],
                    'created_at' => $row['area_created_at']
                ],
                'size' => [
                    'id' => $row['size'],
                    'name' => $row['size_name'],
                    'description' => $row['size_description'],
                    'created_at' => $row['size_created_at']
                ],
                'address' => [
                    'id' => $row['address'],
                    'name' => $row['address_name'],
                    'description' => $row['address_description'],
                    'created_at' => $row['address_created_at']
                ],
                'view' => $row['view'],
                'investor' => $row['investor'],
                'implement_at' => $row['implement_at'],
                'implement_unit' => $row['implement_unit'],
                'detail_floor' => $row['detail_floor'],
                'detail_area' => $row['detail_area'],
                'image_path' => $row['image_path'],
                'video' => $row['video'],
                'status' => $row['status'],
                'created_at' => $row['created_at'],
                'images' =>
                    (function() use ($pdo, $project_id) {
                        $images = [];
                        $imgStmt = $pdo->prepare("SELECT * FROM project_images WHERE project_id = ? AND is_primary != 1 ORDER BY id ASC");
                        $imgStmt->execute([$project_id]);
                        while ($img = $imgStmt->fetch()) {
                            $images[] = [
                                'id' => $img['id'],
                                'image_path' => $img['image_path'],
                                'uploaded_at' => $img['uploaded_at']
                            ];
                        }
                        return $images;
                    })()
            ],
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Project not found'
        ];
    }

    echo json_encode($response);
?>
