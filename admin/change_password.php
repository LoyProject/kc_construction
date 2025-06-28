<?php
    session_start();
    $page_title = "Change Password";
    require_once 'includes/functions.php';
    require_once 'includes/header.php';

    if (!isset($_SESSION['temp_user_id'])) {
        header("Location: login");
        exit;
    }

    $form_errors = $_SESSION['form_errors'] ?? [];
    unset($_SESSION['form_errors']);
?>

<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6 text-brand-blue">Change Password</h1>

    <?php if (!empty($form_errors)): ?>
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md" role="alert">
            <p class="font-bold">Please correct the following errors:</p>
            <ul class="list-disc list-inside ml-4 text-sm">
                <?php foreach ($form_errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="process_change_password.php" method="POST">        
        <div class="mb-4 hidden">
            <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1">Current Password <span class="text-red-500">*</span></label>
            <input type="password" name="current_password" id="current_password" required
                value="123456"
                class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
        </div>
        <div class="mb-4">
            <label for="new_password" class="block text-sm font-medium text-slate-700 mb-1">New Password <span class="text-red-500">*</span></label>
            <input type="password" name="new_password" id="new_password" required
                class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
        </div>
        <div class="mb-6">
            <label for="confirm_password" class="block text-sm font-medium text-slate-700 mb-1">Confirm New Password <span class="text-red-500">*</span></label>
            <input type="password" name="confirm_password" id="confirm_password" required
                class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" name="submit_change_password" class="bg-brand-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-sm w-full">Change Password</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>

<script>
    document.querySelectorAll('input[type="password"]').forEach(function(input) {
        const wrapper = input.parentElement;
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.innerHTML = 'Show';
        btn.className = 'absolute right-3 top-2 text-gray-400 text-xs';
        btn.style.zIndex = 20;
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = 'Hide';
            } else {
                input.type = 'password';
                btn.innerHTML = 'Show';
            }
        });
        wrapper.style.position = 'relative';
        wrapper.appendChild(btn);
    });
</script>
