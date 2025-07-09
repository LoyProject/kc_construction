<?php
    $page_title = "Edit Achievement";
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/header.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_achievements");
        exit;
    }

    $achievement_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $achievement = [];
    $achievement_items = [];
    $slideshow_images = [];

    if ($achievement_id) {
        try {
            $stmt_achievement = $pdo->prepare("SELECT * FROM achievements WHERE id = ?");
            $stmt_achievement->execute([$achievement_id]);
            $achievement = $stmt_achievement->fetch(PDO::FETCH_ASSOC);

            $stmt_achievement_items = $pdo->prepare("SELECT * FROM achievement_items WHERE achievement_id = ?");
            $stmt_achievement_items->execute([$achievement_id]);
            $achievement_items = $stmt_achievement_items->fetchAll(PDO::FETCH_ASSOC);

            $stmt_slideshow_images = $pdo->prepare("SELECT * FROM slideshow WHERE achievement_id = ? ORDER BY id ASC");
            $stmt_slideshow_images->execute([$achievement_id]);
            $slideshow_images = $stmt_slideshow_images->fetchAll(PDO::FETCH_ASSOC);
            foreach ($slideshow_images as $image) {
                $achievement_images[] = [
                    'id' => $image['id'],
                    'image_path' => $image['image_path']
                ];
            }
        } catch (PDOException $e) {
            error_log("Error fetching achievement data: " . $e->getMessage());
            $_SESSION['message'] = "Error fetching achievement data.";
            $_SESSION['message_type'] = "error";
            header("Location: manage_achievements");
            exit;
        }
    } else {
        $_SESSION['message'] = "Invalid achievement ID.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_achievements");
        exit;
    }

    function field_value($key, $default = '') {
        global $form_data, $achievement;
        if (isset($form_data[$key])) return $form_data[$key];
        if (isset($achievement[$key])) return $achievement[$key];
        return $default;
    }
?>

<div class="md:col-span-1">
    <h2 class="text-xl font-bold mb-4 truncate">Edit Achievement: <?php echo sanitize_output($achievement['title']); ?></h2>
    
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

    <form action="process_edit_achievement.php?id=<?php echo $achievement_id; ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="hidden" name="id" value="<?php echo $achievement_id; ?>">

        <div>
            <label id="name" class="block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" required class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output(field_value('title')); ?>">
        </div>
        <div>
            <label id="subtitle" class="block text-sm font-medium text-gray-700">Subtitle <span class="text-red-500">*</span></label>
            <textarea name="subtitle" required class="mt-1 block w-full border border-gray-300 rounded-md p-2"><?php echo sanitize_output(field_value('subtitle')); ?></textarea>
        </div>
        <?php if (!empty($achievement_items)): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php foreach ($achievement_items as $index => $item): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Achievement Name <?php echo $index + 1; ?> <span class="text-red-500">*</span></label>
                        <input type="text" name="achievement_name_<?php echo $index + 1; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                            value="<?php echo sanitize_output($item['name']); ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Achievement Description <?php echo $index + 1; ?> <span class="text-red-500">*</span></label>
                        <input type="text" name="achievement_description_<?php echo $index + 1; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                            value="<?php echo sanitize_output($item['description']); ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Achievement Image <?php echo $index + 1; ?> <span class="text-red-500">*</span></label>
                        <input type="file" name="achievement_image_<?php echo $index + 1; ?>" accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-md p-[5.5px]">
                        <p class="text-xs text-red-500">Leave blank to keep existing image.</p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-slate-500 mb-4">No achievement items found for this achievement.</p>
        <?php endif; ?>
        <div>
            <h2 class="text-xl font-semibold mb-3 text-slate-700">Manage Existing Slideshows</h2>
            <?php if (!empty($achievement_images)): ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                    <?php foreach ($achievement_images as $image): ?>
                        <div class="relative border p-2 rounded-md shadow-sm">
                            <img src="<?php echo sanitize_output($image['image_path']); ?>" alt="achievement image" class="w-full h-32 object-cover rounded mb-2">
                            <label for="delete_image_<?php echo $image['id']; ?>" class="flex items-center text-xs text-red-600 hover:text-red-800 cursor-pointer">
                                <input type="checkbox" name="delete_images[]" id="delete_image_<?php echo $image['id']; ?>" value="<?php echo $image['id']; ?>" class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                <span class="ml-1">Delete</span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-slate-500 mb-4">No existing slideshows for this achievement.</p>
            <?php endif; ?>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Upload New Slideshow(s)</label>
            <input type="file" name="slideshow_images[]" multiple accept="image/*" class="mt-1 block w-full">
            <p class="mt-1 text-xs text-slate-500">You can select multiple images. PNG, JPG, JPEG up to 3MB each.</p>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
            <a href="manage_achievements" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2 px-4 rounded-md shadow-sm">Cancel</a>
            <button type="submit" name="submit_edit_achievement" class="bg-brand-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">Save Changes</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
