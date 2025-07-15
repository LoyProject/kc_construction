<?php
    $page_title = "Add New Company";
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
    <h2 class="text-xl font-bold mb-4">Add New Company</h2>

    <?php
        if (isset($_SESSION['form_errors']) && is_array($_SESSION['form_errors'])) {
            $form_errors = $_SESSION['form_errors'];
            unset($_SESSION['form_errors']);
        }
        if (isset($_SESSION['form_data']) && is_array($_SESSION['form_data'])) {
            $form_data = $_SESSION['form_data'];
            unset($_SESSION['form_data']);
        }
    ?>

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

    <form action="process_add_company" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Company Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
        </div>
        <div>
            <label for="vision" class="block text-sm font-medium text-gray-700">Vision</label>
            <textarea name="vision" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <input type="text" name="address" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>
        <div>
            <label for="map" class="block text-sm font-medium text-gray-700">Google Map</label>
            <textarea name="map" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div>
                <label for="tell" class="block text-sm font-medium text-gray-700">Telephone</label>
                <input type="text" name="tell" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="schedule" class="block text-sm font-medium text-gray-700">Schedule</label>
                <input type="text" name="schedule" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="facebook" class="block text-sm font-medium text-gray-700">Facebook</label>
                <input type="url" name="facebook" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="telegram" class="block text-sm font-medium text-gray-700">Telegram</label>
                <input type="url" name="telegram" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="tiktok" class="block text-sm font-medium text-gray-700">TikTok</label>
                <input type="url" name="tiktok" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="youtube" class="block text-sm font-medium text-gray-700">YouTube</label>
                <input type="url" name="youtube" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
        </div>
        <div>
            <label for="logo" class="block text-sm font-medium text-gray-700">Company Logo <span class="text-red-500">*</span></label>
            <input type="file" name="logo" accept="image/*" class="mt-1 block w-full">
            <p class="mt-1 text-xs text-slate-500">Upload a company logo image (PNG, JPG, JPEG up to 5MB).</p>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
            <a href="manage_companies" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2 px-4 rounded-md shadow-sm">Cancel</a>
            <button type="submit" name="submit_add_company" class="bg-brand-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">Add Company</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
