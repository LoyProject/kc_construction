<?php
    $page_title = "Reset Users";
    require_once 'includes/admin_auth_check.php'; 
    require_once 'includes/functions.php';
    require_once 'includes/header.php';
    require_once 'includes/db_connect.php';

    try {
        $users_stmt = $pdo->query("SELECT * FROM users WHERE status = 'Active' AND username != 'chheanghok' ORDER BY id DESC");
        $users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching users for reset form: " . $e->getMessage());
        $users = [];
    }

    $form_data = $_SESSION['form_data'] ?? [];
    $form_errors = $_SESSION['form_errors'] ?? [];
    unset($_SESSION['form_data'], $_SESSION['form_errors']);
?>


<div class="md:col-span-1">
    <h1 class="text-xl font-bold mb-2">Reset User Password</h1>
    <p class="text-sm text-slate-600 mb-6">Use this form to reset a user's password.</p>

    <?php if (!empty($form_errors)): ?>
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md" role="alert">
            <p class="font-bold">Please correct the following errors:</p>
            <ul class="list-disc list-inside ml-4"><?php foreach ($form_errors as $error) echo "<li>$error</li>"; ?></ul>
        </div>
    <?php endif; ?>

    <form action="process_reset_user" method="POST">        
        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-slate-700 mb-1">User <span class="text-red-500">*</span></label>
            <select name="user_id" id="user_id" required class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm h-[42px]">
                <option></option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo $user['id']; ?>" <?php if (($form_data['user_id'] ?? '') == $user['id']) echo 'selected'; ?>>
                        <?php echo sanitize_output($user['username']); ?> (Email: <?php echo sanitize_output($user['email'] ?? 'N/A'); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4 hidden">
            <div class="mb-4">
                <label for="new_password" class="block text-sm font-medium text-slate-700 mb-1">New Password <span class="text-red-500">*</span></label>
                <input type="password" name="new_password" id="new_password" required
                       value="123456"
                       class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="confirm_password" class="block text-sm font-medium text-slate-700 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                <input type="password" name="confirm_password" id="confirm_password" required
                       value="123456"
                       class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-200 mt-2">
            <a href="manage_users" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2 px-4 rounded-md shadow-sm">Cancel</a>
            <button type="submit" name="submit_reset_user" class="bg-brand-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">Reset Password</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: "Select a User",
            allowClear: true
        });
    });
</script>
