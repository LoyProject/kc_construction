<?php
    $page_title = "Add New Request";
    require_once 'includes/admin_auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/header.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_companies");
        exit;
    }

    $form_data = $_SESSION['form_data'] ?? [];
    $form_errors = $_SESSION['form_errors'] ?? [];
    unset($_SESSION['form_data'], $_SESSION['form_errors']);
?>

<div class="md:col-span-1">
    <h2 class="text-xl font-bold mb-4">Add New Request</h2>

    <?php if (!empty($form_errors)): ?>
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md" role="alert">
            <p class="font-bold">Please correct the following errors:</p>
            <ul class="list-disc list-inside ml-4">
                <?php foreach ($form_errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="process_add_request" method="POST" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($form_data['name'] ?? ''); ?>">
        </div>
        <div>
            <label for="tell" class="block text-sm font-medium text-gray-700">Telephone <span class="text-red-500">*</span></label>
            <input type="text" name="tell" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($form_data['tell'] ?? ''); ?>">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>">
        </div>
        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700">Subject <span class="text-red-500">*</span></label>
            <input type="text" name="subject" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($form_data['subject'] ?? ''); ?>">
        </div>
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700">Message <span class="text-red-500">*</span></label>
            <textarea name="message" required class="mt-1 block w-full border border-gray-300 rounded-md p-2"><?php echo htmlspecialchars($form_data['message'] ?? ''); ?></textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
            <a href="manage_requests" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2 px-4 rounded-md shadow-sm">Cancel</a>
            <button type="submit" name="submit_add_request" class="bg-brand-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">Add Request</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
