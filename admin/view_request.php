<?php
    $page_title = "View Request";
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/header.php';
    require_once 'includes/db_connect.php';

    $request_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $request = null;

    if (!$request_id) {
        $_SESSION['message'] = "Invalid request ID specified.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_requests");
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM requests WHERE id = :id");
        $stmt->bindParam(':id', $request_id, PDO::PARAM_INT);
        $stmt->execute();
        $request = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$request) {
            $_SESSION['message'] = "Request not found.";
            $_SESSION['message_type'] = "error";
            header("Location: manage_requests");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Database error fetching request for view: " . $e->getMessage());
        $_SESSION['message'] = "Error fetching request details.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_requests");
        exit;
    }
?>

<div class="md:col-span-1">
    <h1 class="text-xl font-bold mb-4 truncate">View Request: <?php echo sanitize_output($request['name']); ?></h1>

    <div class="mb-4">
        <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
        <div class="mt-1 block w-full px-3 py-2 bg-slate-100 border border-slate-300 rounded-md shadow-sm sm:text-sm">
            <?php echo sanitize_output($request['name']); ?>
        </div>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-slate-700 mb-1">Telephone</label>
        <div class="mt-1 block w-full px-3 py-2 bg-slate-100 border border-slate-300 rounded-md shadow-sm sm:text-sm">
            <?php echo sanitize_output($request['tell']); ?>
        </div>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
        <div class="mt-1 block w-full px-3 py-2 bg-slate-100 border border-slate-300 rounded-md shadow-sm sm:text-sm">
            <?php echo sanitize_output($request['email']); ?>
        </div>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-slate-700 mb-1">Subject</label>
        <div class="mt-1 block w-full px-3 py-2 bg-slate-100 border border-slate-300 rounded-md shadow-sm sm:text-sm">
            <?php echo sanitize_output($request['subject']); ?>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-sm font-medium text-slate-700 mb-1">Message</label>
        <div class="mt-1 block w-full px-3 py-2 bg-slate-100 border border-slate-300 rounded-md shadow-sm sm:text-sm">
            <?php echo nl2br(sanitize_output($request['message'])); ?>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-sm font-medium text-slate-700 mb-1">Created At</label>
        <div class="mt-1 block w-full px-3 py-2 bg-slate-100 border border-slate-300 rounded-md shadow-sm sm:text-sm">
            <?php echo sanitize_output($request['created_at']); ?>
        </div>
    </div>

    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
        <a href="manage_requests" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2 px-4 rounded-md shadow-sm">Back</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
