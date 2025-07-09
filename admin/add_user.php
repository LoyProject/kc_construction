<?php
    $page_title = "Add New Users";
    require_once 'includes/admin_auth_check.php'; 
    require_once 'includes/functions.php';
    require_once 'includes/header.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_users");
        exit;
    }

    $form_data = $_SESSION['form_data'] ?? [];
    $form_errors = $_SESSION['form_errors'] ?? [];
    unset($_SESSION['form_data'], $_SESSION['form_errors']);
?>

<div class="md:col-span-1">
    <h2 class="text-xl font-bold mb-4">Add New User</h2>

    <form action="process_add_user" method="POST" class="space-y-4">
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">User Name <span class="text-red-500">*</span></label>
            <input type="text" name="username" id="username" required 
                    value="<?php echo htmlspecialchars($form_data['username'] ?? ''); ?>" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
            <input type="email" name="email" id="email" required 
                    value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="role" class="mb-1 block text-sm font-medium text-gray-700">Role <span class="text-red-500">*</span></label>
            <select name="role" id="role" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option></option>
                <option value="Admin" <?php echo (isset($form_data['role']) && $form_data['role'] === 'Admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="Editor" <?php echo (isset($form_data['role']) && $form_data['role'] === 'Editor') ? 'selected' : ''; ?>>Editor</option>
                <option value="View" <?php echo (isset($form_data['role']) && $form_data['role'] === 'View') ? 'selected' : ''; ?>>View</option>
            </select>
            <?php if (!empty($form_errors['role'])): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo htmlspecialchars($form_errors['role'] ?? ''); ?></p>
            <?php endif; ?>
        </div>
        <div class="hidden">
            <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
            <div class="relative">
                <input id="password" type="password" name="password" required
                        value="123456"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <button type="button" data-target="password" class="toggle-password-btn absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-blue-600">
                    <svg class="shrink-0 size-3.5" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path class="eye" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                        <circle class="pupil" cx="12" cy="12" r="3"></circle>
                        <line class="slash" x1="2" y1="2" x2="22" y2="22" style="display:none;"></line>
                    </svg>
                </button>
            </div>
        </div>
        <div class="hidden">
            <label for="password_confirm" class="block text-sm font-medium text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
            <div class="relative">
                <input id="password_confirm" type="password" name="password_confirm" required
                        value="123456"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <button type="button" data-target="password_confirm" class="toggle-password-btn absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-blue-600">
                    <svg class="shrink-0 size-3.5" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path class="eye" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                        <circle class="pupil" cx="12" cy="12" r="3"></circle>
                        <line class="slash" x1="2" y1="2" x2="22" y2="22" style="display:none;"></line>
                    </svg>
                </button>
            </div>
        </div>
        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
            <a href="manage_users" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2 px-4 rounded-md shadow-sm">Cancel</a>
            <button type="submit" name="submit_add_user" class="bg-brand-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">Add User</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#role').select2({
            placeholder: "Select a Role",
            allowClear: true
        });
    });

    $(window).resize(function() {
        $('#role').select2({
            placeholder: "Select a Role",
            allowClear: true
        });
    });

    document.querySelectorAll('.toggle-password-btn').forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const svg = button.querySelector('svg');
            const slash = svg.querySelector('.slash');
            const eye = svg.querySelector('.eye');
            const pupil = svg.querySelector('.pupil');

            if (input.type === 'password') {
                input.type = 'text';
                slash.style.display = 'block';
                eye.style.opacity = '0.5';
                pupil.style.opacity = '0.5';
            } else {
                input.type = 'password';
                slash.style.display = 'none';
                eye.style.opacity = '1';
                pupil.style.opacity = '1';
            }
        });
    });
</script>
