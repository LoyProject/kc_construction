<?php
    $page_title = "Edit Style";
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/header.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_styles");
        exit;
    }

    $style_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $style = null;

    if (!$style_id) {
        $_SESSION['message'] = "Invalid style ID specified.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_styles");
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM styles WHERE id = :id");
        $stmt->bindParam(':id', $style_id, PDO::PARAM_INT);
        $stmt->execute();
        $style = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$style) {
            $_SESSION['message'] = "Style not found.";
            $_SESSION['message_type'] = "error";
            header("Location: manage_styles");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Database error fetching style for edit: " . $e->getMessage());
        $_SESSION['message'] = "Error fetching style details.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_styles");
        exit;
    }

    $form_data = $_SESSION['form_data'] ?? $style;
    $form_errors = $_SESSION['form_errors'] ?? [];
    unset($_SESSION['form_data'], $_SESSION['form_errors']);
?>

<div class="md:col-span-1">
    <h1 class="text-xl font-bold mb-4 truncate">Edit Style: <?php echo sanitize_output($style['name']); ?></h1>

    <form action="process_edit_style" method="POST">
        <input type="hidden" name="style_id" value="<?php echo sanitize_output($style['id']); ?>">

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Style Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" required
                   value="<?php echo sanitize_output($form_data['name'] ?? ''); ?>"
                   class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description (Optional)</label>
            <textarea name="description" id="description" rows="4"
                      class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm"><?php echo sanitize_output($form_data['description'] ?? ''); ?></textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
            <a href="manage_styles" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2 px-4 rounded-md shadow-sm">Cancel</a>
            <button type="submit" name="submit_edit_style" class="bg-brand-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">Save Changes</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
