<?php
    require_once 'includes/admin_auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/db_connect.php';

    header('Content-Type: application/json');
    $response = ['success' => false, 'message' => 'An unknown error occurred.'];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Invalid request method.';
        echo json_encode($response);
        exit;
    }

    $company_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$company_id) {
        $response['message'] = "Invalid company ID.";
        echo json_encode($response);
        exit;
    }

    try {
        $pdo->beginTransaction();

        $stmt_main_image = $pdo->prepare("SELECT logo FROM companies WHERE id = :id");
        $stmt_main_image->execute([':id' => $company_id]);
        $main_logo = $stmt_main_image->fetchColumn();

        $logos_to_delete = [];
        if ($main_logo) {
            $logos_to_delete[] = $main_logo;
        }

        $stmt_delete_company = $pdo->prepare("DELETE FROM companies WHERE id = :id");
        if ($stmt_delete_company->execute([':id' => $company_id])) {
            if ($stmt_delete_company->rowCount() > 0) {
                foreach ($logos_to_delete as $path) {
                    if (!empty($path) && file_exists($path)) {
                        if (!unlink($path)) {
                            error_log("Failed to delete image file: " . $path);
                        }
                    }
                }

                $pdo->commit();
                $response['success'] = true;
                $response['message'] = "Company and associated logo deleted successfully.";
            } else {
                throw new Exception("Company not found or already deleted.");
            }
        } else {
            throw new Exception("Failed to execute delete statement for the company.");
        }

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("Company deletion error: " . $e->getMessage());
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
    exit;
?>
