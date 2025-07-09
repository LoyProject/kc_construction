<?php
    $page_title = "Add New Project";
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
?>


<div class="md:col-span-1">
    <h2 class="text-xl font-bold mb-4">Add New Project</h2>

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

    <form action="process_add_project" method="POST" enctype="multipart/form-data" class="space-y-4">        
        <div>
            <label id="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>

        <div class="grid grid-cols-4 gap-4">
            <div>
                <label for="style_id" class="mb-[4px] block text-sm font-medium text-gray-700">Style <span class="text-red-500">*</span></label>
                <select name="style_id" id="style_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php if (!empty($styles)): ?>
                        <?php foreach ($styles as $style): ?>
                            <option value="<?php echo sanitize_output($style['id']); ?>"
                                <?php if (isset($form_data['style_id']) && $form_data['style_id'] == $style['id']) echo 'selected'; ?>>
                                <?php echo sanitize_output($style['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No styles available. Please add one first.</option>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label for="type_id" class="mb-[4px] block text-sm font-medium text-gray-700">Type <span class="text-red-500">*</span></label>
                <select name="type_id" id="type_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php if (!empty($types)): ?>
                        <?php foreach ($types as $type): ?>
                            <option value="<?php echo sanitize_output($type['id']); ?>"
                                <?php if (isset($form_data['type_id']) && $form_data['type_id'] == $type['id']) echo 'selected'; ?>>
                                <?php echo sanitize_output($type['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No types available. Please add one first.</option>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label for="floor_id" class="mb-[4px] block text-sm font-medium text-gray-700">Number of Floors</label>
                <select name="floor_id" id="floor_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php if (!empty($floors)): ?>
                        <?php foreach ($floors as $floor): ?>
                            <option value="<?php echo sanitize_output($floor['id']); ?>"
                                <?php if (isset($form_data['floor_id']) && $form_data['floor_id'] == $floor['id']) echo 'selected'; ?>>
                                <?php echo sanitize_output($floor['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No floors available. Please add one first.</option>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label for="facade_id" class="mb-[4px] block text-sm font-medium text-gray-700">Facades <span class="text-red-500">*</span></label>
                <select name="facade_id" id="facade_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php if (!empty($facades)): ?>
                        <?php foreach ($facades as $facade): ?>
                            <option value="<?php echo sanitize_output($facade['id']); ?>"
                                <?php if (isset($form_data['facade_id']) && $form_data['facade_id'] == $facade['id']) echo 'selected'; ?>>
                                <?php echo sanitize_output($facade['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No facades available. Please add one first.</option>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label for="area_id" class="mb-[4px] block text-sm font-medium text-gray-700">Area (m²) <span class="text-red-500">*</span></label>
                <select name="area_id" id="area_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php if (!empty($areas)): ?>
                        <?php foreach ($areas as $area): ?>
                            <option value="<?php echo sanitize_output($area['id']); ?>"
                                <?php if (isset($form_data['area_id']) && $form_data['area_id'] == $area['id']) echo 'selected'; ?>>
                                <?php echo sanitize_output($area['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No areas available. Please add one first.</option>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label for="size_id" class="mb-[4px] block text-sm font-medium text-gray-700">Size</label>
                <select name="size_id" id="size_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php if (!empty($sizes)): ?>
                        <?php foreach ($sizes as $size): ?>
                            <option value="<?php echo sanitize_output($size['id']); ?>"
                                <?php if (isset($form_data['size_id']) && $form_data['size_id'] == $size['id']) echo 'selected'; ?>>
                                <?php echo sanitize_output($size['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No sizes available. Please add one first.</option>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label id="view" class="block text-sm font-medium text-gray-700">View</label>
                <input type="number" name="view" value="0" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>

            <div>
                <label id="investor" class="block text-sm font-medium text-gray-700">Investor</label>
                <input type="text" name="investor" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>

            <div>
                <label for="address_id" class="mb-[4px] block text-sm font-medium text-gray-700">Address</label>
                <select name="address_id" id="address_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                    <option></option>
                    <?php if (!empty($addresses)): ?>
                        <?php foreach ($addresses as $address): ?>
                            <option value="<?php echo sanitize_output($address['id']); ?>"
                                <?php if (isset($form_data['address_id']) && $form_data['address_id'] == $address['id']) echo 'selected'; ?>>
                                <?php echo sanitize_output($address['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No addresses available. Please add one first.</option>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label id="implement_at" class="block text-sm font-medium text-gray-700">Implement At</label>
                <input type="number" name="implement_at" minlength="4" maxlength="4" min="1000" max="9999" class="mt-1 block w-full border border-gray-300 rounded-md p-2" pattern="\d{4}" title="Please enter a 4-digit year">
            </div>

            <div>
                <label id="implement_unit" class="block text-sm font-medium text-gray-700">Implement Unit</label>
                <input type="text" name="implement_unit" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
        </div>

        <div>
            <label id="detail_floor" class="block text-sm font-medium text-gray-700">Detail About Floor</label>
            <textarea name="detail_floor" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
        </div>

        <div>
            <label id="detail_area" class="block text-sm font-medium text-gray-700">Detail of Area</label>
            <textarea name="detail_area" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Video Link (YouTube, Vimeo, etc.)</label>
            <input type="url" name="video" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="https://example.com/video">
            <p class="mt-1 text-xs text-slate-500">Optional. Paste a video URL to display with the project.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Upload Images</label>
            <input type="file" name="images[]" multiple accept="image/*" class="mt-1 block w-full">
            <p class="mt-1 text-xs text-slate-500">You can select multiple images. PNG, JPG, JPEG up to 3MB each.</p>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
            <a href="manage_projects" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2 px-4 rounded-md shadow-sm">Cancel</a>
            <button type="submit" name="submit_add_project" class="bg-brand-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">Add Project</button>
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