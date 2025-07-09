<?php
    $page_title = "Add New Achievement";
    require_once 'includes/admin_auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/header.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_achievements");
        exit;
    }

    $form_data = $_SESSION['form_data'] ?? [];
    $form_errors = $_SESSION['form_errors'] ?? [];
    unset($_SESSION['form_data'], $_SESSION['form_errors']);
?>


<div class="md:col-span-1">
    <h2 class="text-xl font-bold mb-4">Add New Achievement</h2>

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

    <form action="process_add_achievement" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>
        <div>
            <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle <span class="text-red-500">*</span></label>
            <textarea name="subtitle" required class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="achievement_name_1" class="block text-sm font-medium text-gray-700">Achievement Name 1 <span class="text-red-500">*</span></label>
                <input type="text" name="achievement_name_1" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="achievement_description_1" class="block text-sm font-medium text-gray-700">Achievement Description 1 <span class="text-red-500">*</span></label>
                <input type="text" name="achievement_description_1" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="achievement_image_1" class="block text-sm font-medium text-gray-700">Achievement Image 1 <span class="text-red-500">*</span></label>
                <input type="file" name="achievement_image_1" accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-md p-[5.5px]">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="achievement_name_2" class="block text-sm font-medium text-gray-700">Achievement Name 2 <span class="text-red-500">*</span></label>
                <input type="text" name="achievement_name_2" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="achievement_description_2" class="block text-sm font-medium text-gray-700">Achievement Description 2 <span class="text-red-500">*</span></label>
                <input type="text" name="achievement_description_2" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="achievement_image_2" class="block text-sm font-medium text-gray-700">Achievement Image 2 <span class="text-red-500">*</span></label>
                <input type="file" name="achievement_image_2" accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-md p-[5.5px]">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="achievement_name_3" class="block text-sm font-medium text-gray-700">Achievement Name 3 <span class="text-red-500">*</span></label>
                <input type="text" name="achievement_name_3" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="achievement_description_3" class="block text-sm font-medium text-gray-700">Achievement Description 3 <span class="text-red-500">*</span></label>
                <input type="text" name="achievement_description_3" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="achievement_image_3" class="block text-sm font-medium text-gray-700">Achievement Image 3 <span class="text-red-500">*</span></label>
                <input type="file" name="achievement_image_3" accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-md p-[5.5px]">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Upload Slideshow <span class="text-red-500">*</span></label>
            <input type="file" name="slideshow_images[]" multiple accept="image/*" class="mt-1 block w-full">
            <p class="mt-1 text-xs text-slate-500">You can select multiple images. PNG, JPG, JPEG up to 3MB each.</p>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
            <a href="manage_achievements" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2 px-4 rounded-md shadow-sm">Cancel</a>
            <button type="submit" name="submit_add_achievement" class="bg-brand-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">Add Achievement</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
