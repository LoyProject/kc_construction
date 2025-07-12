<?php
    require_once(__DIR__ . '/../admin/includes/db_connect.php');
    header('Content-Type: application/json');

    $style = $_GET['style'] ?? '';
    $type = $_GET['type'] ?? '';
    $floor = $_GET['floor'] ?? '';
    $area = $_GET['area'] ?? '';
    $facade = $_GET['facade'] ?? '';

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 16;
    $offset = ($page - 1) * $limit;

    $whereClause = [];
    $params = [];

    if (!empty($style)) {
        $whereClause[] = "p.style_id = ?";
        $params[] = $style;
    }
    if (!empty($type)) {
        $whereClause[] = "p.type_id = ?";
        $params[] = $type;
    }
    if (!empty($floor)) {
        $whereClause[] = "p.floor_id = ?";
        $params[] = $floor;
    }
    if (!empty($area)) {
        $whereClause[] = "p.area_id = ?";
        $params[] = $area;
    }
    if (!empty($facade)) {
        $whereClause[] = "p.facade_id = ?";
        $params[] = $facade;
    }

    $whereClause[] = "p.status = 'Active'";
    $whereSQL = count($whereClause) ? 'WHERE ' . implode(' AND ', $whereClause) : '';

    try {
        $countSql = "SELECT COUNT(*) FROM projects p $whereSQL";
        $countStmt = $pdo->prepare($countSql);
        $countStmt->execute($params);
        $totalProjects = $countStmt->fetchColumn();

        $sql = "
            SELECT 
                p.*, 
                s.name AS style_name, s.description AS style_description, s.created_at AS style_created_at,
                t.name AS type_name, t.description AS type_description, t.created_at AS type_created_at,
                f.name AS floor_name, f.description AS floor_description, f.created_at AS floor_created_at,
                fa.name AS facade_name, fa.description AS facade_description, fa.created_at AS facade_created_at,
                a.name AS area_name, a.description AS area_description, a.created_at AS area_created_at,
                sz.name AS size_name, sz.description AS size_description, sz.created_at AS size_created_at,
                ad.name AS address_name, ad.description AS address_description, ad.created_at AS address_created_at
            FROM projects p
            LEFT JOIN styles s ON p.style_id = s.id
            LEFT JOIN types t ON p.type_id = t.id
            LEFT JOIN floors f ON p.floor_id = f.id
            LEFT JOIN facades fa ON p.facade_id = fa.id
            LEFT JOIN areas a ON p.area_id = a.id
            LEFT JOIN sizes sz ON p.size_id = sz.id
            LEFT JOIN addresses ad ON p.address_id = ad.id
            $whereSQL
            ORDER BY p.id ASC
            LIMIT $limit OFFSET $offset
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $projects = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $projects[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'style' => [
                    'id' => $row['style_id'],
                    'name' => $row['style_name'],
                    'description' => $row['style_description'],
                    'created_at' => $row['style_created_at'],
                ],
                'type' => [
                    'id' => $row['type_id'],
                    'name' => $row['type_name'],
                    'description' => $row['type_description'],
                    'created_at' => $row['type_created_at'],
                ],
                'floor' => [
                    'id' => $row['floor_id'],
                    'name' => $row['floor_name'],
                    'description' => $row['floor_description'],
                    'created_at' => $row['floor_created_at'],
                ],
                'facade' => [
                    'id' => $row['facade_id'],
                    'name' => $row['facade_name'],
                    'description' => $row['facade_description'],
                    'created_at' => $row['facade_created_at'],
                ],
                'area' => [
                    'id' => $row['area_id'],
                    'name' => $row['area_name'],
                    'description' => $row['area_description'],
                    'created_at' => $row['area_created_at'],
                ],
                'size' => [
                    'id' => $row['size_id'],
                    'name' => $row['size_name'],
                    'description' => $row['size_description'],
                    'created_at' => $row['size_created_at'],
                ],
                'address' => [
                    'id' => $row['address_id'],
                    'name' => $row['address_name'],
                    'description' => $row['address_description'],
                    'created_at' => $row['address_created_at'],
                ],
                'view' => $row['view'],
                'investor' => $row['investor'],
                'implement_at' => $row['implement_at'],
                'implement_unit' => $row['implement_unit'],
                'budget' => $row['budget'],
                'detail_floor' => $row['detail_floor'],
                'detail_area' => $row['detail_area'],
                'image_path' => $row['image_path'],
                'video' => $row['video'],
                'status' => $row['status'],
                'created_at' => $row['created_at'],
            ];
        }

        $response = [
            'success' => true,
            'projects' => $projects,
            'pagination' => [
                'total' => (int)$totalProjects,
                'page' => $page,
                'limit' => $limit,
                'pages' => ceil($totalProjects / $limit)
            ]
        ];

        echo json_encode($response);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching projects: ' . $e->getMessage()]);
        exit;
    }
?>
