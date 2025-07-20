<?php
    $page_title = "Edit Project";
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/header.php';
    require_once 'includes/db_connect.php';

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'View') {
        $_SESSION['message'] = "You do not have permission to perform that action.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_projects");
        exit;
    }

    try {
        $styles_stmt = $pdo->query("SELECT id, name FROM styles ORDER BY id ASC");
        $styles = $styles_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching styles for add form: " . $e->getMessage());
        $styles = [];
    }

    try {
        $types_stmt = $pdo->query("SELECT id, name FROM types ORDER BY id ASC");
        $types = $types_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching types for add form: " . $e->getMessage());
        $types = [];
    }

    try {
        $floors_stmt = $pdo->query("SELECT id, name FROM floors ORDER BY id ASC");
        $floors = $floors_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching floors for add form: " . $e->getMessage());
        $floors = [];
    }

    try {
        $facades_stmt = $pdo->query("SELECT id, name FROM facades ORDER BY id ASC");
        $facades = $facades_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching facades for add form: " . $e->getMessage());
        $facades = [];
    }

    try {
        $areas_stmt = $pdo->query("SELECT id, name FROM areas ORDER BY id ASC");
        $areas = $areas_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching areas for add form: " . $e->getMessage());
        $areas = [];
    }

    try {
        $sizes_stmt = $pdo->query("SELECT id, name FROM sizes ORDER BY id ASC");
        $sizes = $sizes_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching sizes for add form: " . $e->getMessage());
        $sizes = [];
    }

    try {
        $addresses_stmt = $pdo->query("SELECT id, name FROM addresses ORDER BY id ASC");
        $addresses = $addresses_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching addresses for add form: " . $e->getMessage());
        $addresses = [];
    }

    $project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $project = [];
    if ($project_id) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
            $stmt->execute([$project_id]);
            $project = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt_images = $pdo->prepare("SELECT id, image_path, is_primary FROM project_images WHERE project_id = :project_id ORDER BY is_primary DESC, id ASC");
            $stmt_images->bindParam(':project_id', $project_id, PDO::PARAM_INT);
            $stmt_images->execute();
            $project_images = $stmt_images->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching project data: " . $e->getMessage());
            $_SESSION['message'] = "Error fetching project data.";
            $_SESSION['message_type'] = "error";
            header("Location: manage_projects");
            exit;
        }
    } else {
        $_SESSION['message'] = "Invalid project ID.";
        $_SESSION['message_type'] = "error";
        header("Location: manage_projects");
        exit;
    }

    function field_value($key, $default = '') {
        global $form_data, $project;
        if (isset($form_data[$key])) return $form_data[$key];
        if (isset($project[$key])) return $project[$key];
        return $default;
    }
?>

<div class="md:col-span-1">
    <h2 class="text-xl font-bold mb-4 truncate">Edit Project: <?php echo sanitize_output($project['name']); ?></h2>
    
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

    <form action="process_edit_project.php?id=<?php echo $project_id; ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="hidden" name="id" value="<?php echo $project_id; ?>">

        <div>
            <label id="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" required class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output(field_value('name')); ?>">
        </div>

        <div class="grid grid-cols-4 gap-4">
            <div>
                <label for="style_id" class="mb-[4px] block text-sm font-medium text-gray-700">Style <span class="text-red-500">*</span></label>
                <select name="style_id" id="style_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php foreach ($styles as $style): ?>
                        <option value="<?php echo sanitize_output($style['id']); ?>"
                            <?php if (field_value('style_id') == $style['id']) echo 'selected'; ?>>
                            <?php echo sanitize_output($style['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="type_id" class="mb-[4px] block text-sm font-medium text-gray-700">Type <span class="text-red-500">*</span></label>
                <select name="type_id" id="type_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?php echo sanitize_output($type['id']); ?>"
                            <?php if (field_value('type_id') == $type['id']) echo 'selected'; ?>>
                            <?php echo sanitize_output($type['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="floor_id" class="mb-[4px] block text-sm font-medium text-gray-700">Number of Floors</label>
                <select name="floor_id" id="floor_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php foreach ($floors as $floor): ?>
                        <option value="<?php echo sanitize_output($floor['id']); ?>"
                            <?php if (field_value('floor_id') == $floor['id']) echo 'selected'; ?>>
                            <?php echo sanitize_output($floor['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="facade_id" class="mb-[4px] block text-sm font-medium text-gray-700">Facades <span class="text-red-500">*</span></label>
                <select name="facade_id" id="facade_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php foreach ($facades as $facade): ?>
                        <option value="<?php echo sanitize_output($facade['id']); ?>"
                            <?php if (field_value('facade_id') == $facade['id']) echo 'selected'; ?>>
                            <?php echo sanitize_output($facade['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="area_id" class="mb-[4px] block text-sm font-medium text-gray-700">Area (m²) <span class="text-red-500">*</span></label>
                <select name="area_id" id="area_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?php echo sanitize_output($area['id']); ?>"
                            <?php if (field_value('area_id') == $area['id']) echo 'selected'; ?>>
                            <?php echo sanitize_output($area['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="size_id" class="mb-[4px] block text-sm font-medium text-gray-700">Size</label>
                <select name="size_id" id="size_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php foreach ($sizes as $size): ?>
                        <option value="<?php echo sanitize_output($size['id']); ?>"
                            <?php if (field_value('size_id') == $size['id']) echo 'selected'; ?>>
                            <?php echo sanitize_output($size['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label id="view" class="block text-sm font-medium text-gray-700">View</label>
                <input type="number" name="view" value="<?php echo sanitize_output(field_value('view', 0)); ?>" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label id="investor" class="block text-sm font-medium text-gray-700">Investor</label>
                <input type="text" name="investor" class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    value="<?php echo sanitize_output(field_value('investor')); ?>">
            </div>
            <div>
                <label for="address_id" class="mb-[4px] block text-sm font-medium text-gray-700">Address</label>
                <select name="address_id" id="address_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php foreach ($addresses as $address): ?>
                        <option value="<?php echo sanitize_output($address['id']); ?>"
                            <?php if (field_value('address_id') == $address['id']) echo 'selected'; ?>>
                            <?php echo sanitize_output($address['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label id="implement_at" class="block text-sm font-medium text-gray-700">Implement At</label>
                <input type="number" name="implement_at" minlength="4" maxlength="4" min="1000" max="9999"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    pattern="\d{4}" title="Please enter a 4-digit year"
                    value="<?php echo sanitize_output(field_value('implement_at')); ?>">
            </div>
            <div>
                <label id="implement_unit" class="block text-sm font-medium text-gray-700">Implement Unit</label>
                <input type="text" name="implement_unit" class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    value="<?php echo sanitize_output(field_value('implement_unit')); ?>">
            </div>
            <div>
                <label id="budget" class="block text-sm font-medium text-gray-700">Budget</label>
                <input type="text" name="budget" class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    value="<?php echo sanitize_output(field_value('budget')); ?>">
            </div>
        </div>

        <div>
            <label id="detail_floor" class="block text-sm font-medium text-gray-700">Detail About Floor</label>
            <textarea name="detail_floor" class="mt-1 block w-full border border-gray-300 rounded-md p-2"><?php echo sanitize_output(field_value('detail_floor')); ?></textarea>
        </div>

        <div>
            <label id="detail_area" class="block text-sm font-medium text-gray-700">Detail of Area</label>
            <textarea name="detail_area" class="mt-1 block w-full border border-gray-300 rounded-md p-2"><?php echo sanitize_output(field_value('detail_area')); ?></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Video Link (YouTube, Vimeo, etc.)</label>
            <input type="url" name="video" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo sanitize_output(field_value('video')); ?>">
            <p class="mt-1 text-xs text-slate-500">Optional. Paste a video URL to display with the project.</p>
        </div>

        <div>
            <?php
                $video_url = field_value('video');
                if (!empty($video_url)) {
                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $video_url, $matches)) {
                        $youtube_id = $matches[1];
                        echo '<div class="mb-4">';
                        echo '<div class="aspect-w-16 aspect-h-9"><iframe width="560" height="315" src="https://www.youtube.com/embed/' . htmlspecialchars($youtube_id) . '" frameborder="0" allowfullscreen></iframe></div>';
                        echo '</div>';
                    }
                }
            ?>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-3 text-slate-700">Manage Existing Images</h2>
            <?php if (!empty($project_images)): ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                    <?php foreach ($project_images as $image): ?>
                        <div class="relative border p-2 rounded-md shadow-sm">
                            <img src="<?php echo sanitize_output($image['image_path']); ?>" alt="Project image" class="w-full h-32 object-cover rounded mb-2">
                            <label for="delete_image_<?php echo $image['id']; ?>" class="flex items-center text-xs text-red-600 hover:text-red-800 cursor-pointer">
                                <input type="checkbox" name="delete_images[]" id="delete_image_<?php echo $image['id']; ?>" value="<?php echo $image['id']; ?>" class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                <span class="ml-1">Delete</span>
                            </label>
                            <label for="set_primary_<?php echo $image['id']; ?>" class="mt-1 flex items-center text-xs text-blue-600 hover:text-blue-800 cursor-pointer">
                                <input type="radio" name="primary_id" id="set_primary_<?php echo $image['id']; ?>" 
                                    value="<?php echo $image['id']; ?>" 
                                    <?php if($image['is_primary']) echo 'checked'; ?> 
                                    class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-1">Set Primary</span>
                            </label>
                            </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-slate-500 mb-4">No existing images for this project.</p>
            <?php endif; ?>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Upload New Image(s)</label>
            <input type="file" name="images[]" multiple accept="image/*" class="mt-1 block w-full">
            <p class="mt-1 text-xs text-slate-500">You can select multiple images. PNG, JPG, JPEG up to 3MB each.</p>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
            <a href="manage_projects" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2 px-4 rounded-md shadow-sm">Cancel</a>
            <button type="submit" name="submit_edit_project" class="bg-brand-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">Save Changes</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#style_id').select2({
            placeholder: "Select a Style",
            allowClear: true
        });
        $('#type_id').select2({
            placeholder: "Select a Type",
            allowClear: true
        });
        $('#floor_id').select2({
            placeholder: "Select a Floor",
            allowClear: true
        });
        $('#facade_id').select2({
            placeholder: "Select a Facade",
            allowClear: true
        });
        $('#area_id').select2({
            placeholder: "Select an Area",
            allowClear: true
        });
        $('#size_id').select2({
            placeholder: "Select a Size",
            allowClear: true
        });
        $('#address_id').select2({
            placeholder: "Select an Address",
            allowClear: true
        });
    });

    $(window).resize(function() {
        $('#style_id').select2({
            placeholder: "Select a Style",
            allowClear: true
        });
        $('#type_id').select2({
            placeholder: "Select a Type",
            allowClear: true
        });
        $('#floor_id').select2({
            placeholder: "Select a Floor",
            allowClear: true
        });
        $('#facade_id').select2({
            placeholder: "Select a Facade",
            allowClear: true
        });
        $('#area_id').select2({
            placeholder: "Select an Area",
            allowClear: true
        });
        $('#size_id').select2({
            placeholder: "Select a Size",
            allowClear: true
        });
        $('#address_id').select2({
            placeholder: "Select an Address",
            allowClear: true
        });
    });
</script>
