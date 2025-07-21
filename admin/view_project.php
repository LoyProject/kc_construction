<?php
    $page_title = "View Project";
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/header.php';
    require_once 'includes/db_connect.php';

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
?>

<div class="md:col-span-1 space-y-4">
    <h2 class="text-xl font-bold mb-4 truncate">View Project: <?php echo sanitize_output($project['name']); ?></h2>

    <div>
        <label id="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
            value="<?php echo sanitize_output($project['name']); ?>">
    </div>

    <div class="grid grid-cols-4 gap-4">
        <div>
            <label for="style_id" class="block text-sm font-medium text-gray-700">Style <span class="text-red-500">*</span></label>
            <input type="text" name="style_id" id="style_id" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output(get_name_by_id($pdo, 'styles', $project['style_id'])); ?>">
        </div>
        <div>
            <label for="type_id" class="block text-sm font-medium text-gray-700">Type <span class="text-red-500">*</span></label>
            <input type="text" name="type_id" id="type_id" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output(get_name_by_id($pdo, 'types', $project['type_id'])); ?>">
        </div>
        <div>
            <label for="floor_id" class="block text-sm font-medium text-gray-700">Number of Floors</label>
            <input type="text" name="floor_id" id="floor_id" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output(get_name_by_id($pdo, 'floors', $project['floor_id'])); ?>">
        </div>
        <div>
            <label for="facade_id" class="block text-sm font-medium text-gray-700">Facades <span class="text-red-500">*</span></label>
            <input type="text" name="facade_id" id="facade_id" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output($project['facade']); ?>">
        </div>
        <div>
            <label for="area_id" class="block text-sm font-medium text-gray-700">Area (m²) <span class="text-red-500">*</span></label>
            <input type="text" name="area_id" id="area_id" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output($project['area']); ?>">
        </div>
        <div>
            <label for="size_id" class="block text-sm font-medium text-gray-700">Size</label>
            <input type="text" name="size_id" id="size_id" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output($project['size']); ?>">
        </div>
        <div>
            <label id="view" class="block text-sm font-medium text-gray-700">View</label>
            <input type="text" name="view" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output($project['view']); ?>">
        </div>
        <div>
            <label id="investor" class="block text-sm font-medium text-gray-700">Investor</label>
            <input type="text" name="investor" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output($project['investor']); ?>">
        </div>
        <div>
            <label for="address_id" class="mb-[4px] block text-sm font-medium text-gray-700">Address</label>
            <input type="text" name="address_id" id="address_id" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output($project['address']); ?>">
        </div>
        <div>
            <label id="implement_at" class="block text-sm font-medium text-gray-700">Implement At</label>
            <input type="text" name="implement_at" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output($project['implement_at']); ?>">
        </div>
        <div>
            <label id="implement_unit" class="block text-sm font-medium text-gray-700">Implement Unit</label>
            <input type="text" name="implement_unit" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output($project['implement_unit']); ?>">
        </div>
        <div>
            <label id="budget" class="block text-sm font-medium text-gray-700">Budget</label>
            <input type="text" name="budget" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                value="<?php echo sanitize_output($project['budget']); ?>">
        </div>
    </div>

    <div>
        <label id="created_at" class="block text-sm font-medium text-gray-700">Created At</label>
        <input type="text" name="created_at" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"
            value="<?php echo sanitize_output(date('Y-m-d H:i:s', strtotime($project['created_at']))); ?>">
    </div>

    <div>
        <label id="detail_floor" class="block text-sm font-medium text-gray-700">Detail About Floor</label>
        <textarea name="detail_floor" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"><?php echo sanitize_output($project['detail_floor']); ?></textarea>
    </div>

    <div>
        <label id="detail_area" class="block text-sm font-medium text-gray-700">Detail of Area</label>
        <textarea name="detail_area" disabled class="mt-1 block w-full border border-gray-300 rounded-md p-2"><?php echo sanitize_output($project['detail_area']); ?></textarea>
    </div>

    <div>
        <span class="block text-sm font-medium text-gray-700">Video Link</span>
        <div class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            <?php
                $video_url = $project['video'];
                if (!empty($video_url)) {
                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $video_url, $matches)) {
                        $youtube_id = $matches[1];
                        echo '<div class="aspect-w-16 aspect-h-9"><iframe width="560" height="315" src="https://www.youtube.com/embed/' . htmlspecialchars($youtube_id ?? '') . '" frameborder="0" allowfullscreen></iframe></div>';
                    } else {
                        echo '<a href="' . htmlspecialchars($video_url ?? '') . '" target="_blank">' . htmlspecialchars($video_url ?? '') . '</a>';
                    }
                } else {
                    echo '<span class="text-slate-500">No video link provided.</span>';
                }
            ?>
        </div>
    </div>

    <div>
        <h2 class="block text-sm font-medium text-gray-700">Project Images</h2>
        <?php if (!empty($project_images)): ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6 mt-1">
                <?php foreach ($project_images as $image): ?>
                    <div class="relative border p-2 rounded-md shadow-sm">
                        <img src="<?php echo sanitize_output($image['image_path']); ?>" alt="Project image" class="w-full h-32 object-cover rounded mb-2">
                        <?php if($image['is_primary']): ?>
                            <span class="text-xs text-green-600 font-bold">Primary</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-slate-500 mb-6 mt-1">No images for this project.</p>
        <?php endif; ?>
    </div>

    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
        <a href="manage_projects" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2 px-4 rounded-md shadow-sm">Back</a>
    </div>
</div>

<?php
    function get_name_by_id($pdo, $table, $id) {
        if (!$id) return '';
        $stmt = $pdo->prepare("SELECT name FROM $table WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? sanitize_output($row['name']) : '';
    }
?>

<?php require_once 'includes/footer.php'; ?>
