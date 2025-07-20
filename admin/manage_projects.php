<?php
    $page_title = "Manage Projects";
    require_once 'includes/auth_check.php';
    require_once 'includes/functions.php';
    require_once 'includes/header.php';
    require_once 'includes/db_connect.php';

    $search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
    $current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $per_page = 10;
    $offset = ($current_page - 1) * $per_page;

    $filter_status = isset($_GET['status']) && in_array($_GET['status'], ['Active', 'Inactive']) ? $_GET['status'] : 'all';
    $where = [];
    $params = [];

    if ($search_term !== '') {
        // $where[] = "(p.name LIKE ? OR s.name LIKE ? OR t.name LIKE ? OR f.name LIKE ? OR fa.name LIKE ? OR a.name LIKE ? OR ad.name LIKE ?)";
        $where[] = "(p.name LIKE ? OR s.name LIKE ? OR t.name LIKE ? OR f.name LIKE ? OR p.facade LIKE ? OR p.area LIKE ? OR p.address LIKE ?)";
        for ($i = 0; $i < 7; $i++) {
            $params[] = '%' . $search_term . '%';
        }
    }

    if ($filter_status !== 'all') {
        $where[] = "status = :status";
        $params[':status'] = $filter_status;
    }

    $where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    $total_sql = "SELECT COUNT(*) FROM projects p
            LEFT JOIN styles s ON p.style_id = s.id
            LEFT JOIN types t ON p.type_id = t.id
            LEFT JOIN floors f ON p.floor_id = f.id
            -- LEFT JOIN facades fa ON p.facade_id = fa.id
            -- LEFT JOIN areas a ON p.area_id = a.id
            -- LEFT JOIN addresses ad ON p.address_id = ad.id
            $where_sql";
    $stmt = $pdo->prepare($total_sql);
    $stmt->execute($params);
    $total_projects = $stmt->fetchColumn();
    $total_pages = ceil($total_projects / $per_page);

        // $sql = "SELECT p.id, p.image_path, p.name, s.name AS style, t.name AS type, f.name AS floor, fa.name AS facade, a.name AS area, ad.name AS address, status
        $sql = "SELECT p.id, p.image_path, p.name, p.facade AS facade, p.area AS area, p.address AS address, s.name AS style, t.name AS type, f.name AS floor, status
            FROM projects p
            LEFT JOIN styles s ON p.style_id = s.id
            LEFT JOIN types t ON p.type_id = t.id
            LEFT JOIN floors f ON p.floor_id = f.id
            -- LEFT JOIN facades fa ON p.facade_id = fa.id
            -- LEFT JOIN areas a ON p.area_id = a.id
            -- LEFT JOIN addresses ad ON p.address_id = ad.id
            $where_sql 
            ORDER BY id DESC
            LIMIT $per_page OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $base_link_params = array_filter(['search' => $search_term, 'status' => $filter_status]);
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Manage Projects</h1>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'View'): ?>
        <a href="add_project" class="inline-flex items-center justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-brand-blue hover:bg-blue-700">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Add New Project
        </a>
    <?php endif; ?>
</div>

<form action="manage_projects" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end mb-4">
    <div>
        <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search_term ?? ''); ?>" placeholder="Search by name..."
                class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
    </div>
    <div>
        <select name="status" id="filter_status" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
            <option value="all" <?php if ($filter_status === 'all') echo 'selected'; ?>>All Statuses</option>
            <option value="Active" <?php if ($filter_status === 'Active') echo 'selected'; ?>>Active</option>
            <option value="Inactive" <?php if ($filter_status === 'Inactive') echo 'selected'; ?>>Inactive</option>
        </select>
    </div>
    <div class="flex items-center space-x-4">
        <button type="submit" class="w-full sm:w-auto bg-brand-blue text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">Filter</button>
        <a href="manage_projects" class="text-red-500 text-base hover:underline">Clear Filters</a>
    </div>
</form>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-3 py-2 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Image</th>
                <th class="px-3 py-2 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                <th class="px-3 py-2 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Style</th>
                <th class="px-3 py-2 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                <th class="px-3 py-2 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Floor</th>
                <th class="px-3 py-2 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Decade</th>
                <th class="px-3 py-2 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Area</th>
                <th class="px-3 py-2 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                <th class="px-3 py-2 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if (empty($projects)) {
                    echo '<tr><td colspan="10" class="px-3 py-2 border-b text-center text-gray-500">No projects found.</td></tr>';
                } else { 
                    foreach ($projects as $project) {
                        echo '<tr id="project-row-' . htmlspecialchars($project['id'] ?? '') . '" class="text-xs text-left text-gray-700 hover:bg-gray-50 transition-colors">';
                            echo '<td class="px-3 py-2 border-b border-gray-200 font-semibold"><img src="' . htmlspecialchars($project['image_path'] ?? '') . '" alt="" class="w-16 h-16 object-cover rounded"></td>';
                            echo '<td class="w-1/4 px-3 py-2 border-b border-gray-200 max-w-xs truncate" title="' . htmlspecialchars($project['name'] ?? '') . '">' . htmlspecialchars($project['name'] ?? '') . '</td>';
                            echo '<td class="px-3 py-2 border-b border-gray-200 max-w-sm truncate" title="' . htmlspecialchars($project['style'] ?? '') . '">' . htmlspecialchars($project['style'] ?? '') . '</td>';
                            echo '<td class="px-3 py-2 border-b border-gray-200 max-w-sm truncate" title="' . htmlspecialchars($project['type'] ?? '') . '">' . htmlspecialchars($project['type'] ?? '') . '</td>';
                            echo '<td class="px-3 py-2 border-b border-gray-200 max-w-sm truncate" title="' . htmlspecialchars($project['floor'] ?? '') . '">' . htmlspecialchars($project['floor'] ?? '') . '</td>';
                            echo '<td class="px-3 py-2 border-b border-gray-200 max-w-sm truncate" title="' . htmlspecialchars($project['facade'] ?? '') . '">' . htmlspecialchars($project['facade'] ?? '') . '</td>';
                            echo '<td class="px-3 py-2 border-b border-gray-200 max-w-sm truncate" title="' . htmlspecialchars($project['area'] ?? '') . '">' . htmlspecialchars($project['area'] ?? '') . '</td>';
                            echo '<td class="px-3 py-2 border-b border-gray-200 max-w-sm truncate" title="' . htmlspecialchars($project['status'] ?? '') . '">';
                                if (isset($_SESSION['role']) && $_SESSION['role'] !== 'View') {
                                    $status_color = ($project['status'] === 'Active') ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-800';
                                    $button_hover_color = ($project['status'] === 'Active') ? 'hover:bg-green-200' : 'hover:bg-slate-300';
                                    echo '<button 
                                            class="status-toggle-btn px-3 py-1 font-semibold leading-tight rounded-full text-xs transition-colors ' . $status_color . ' ' . $button_hover_color . '"
                                            data-project-id="' . htmlspecialchars($project['id'] ?? '') . '">'
                                            . sanitize_output($project['status']) .
                                        '</button>';
                                } else {
                                    $status_color = ($project['status'] === 'Active') ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-800';
                                    echo '<span class="px-3 py-1 font-semibold leading-tight rounded-full text-xs ' . $status_color . '">'
                                            . sanitize_output($project['status']) .
                                        '</span>';
                                }
                            echo '</td>';
                            echo '<td class="w-24 px-3 py-2 border-b border-gray-200 space-x-3 truncate">';
                                echo '<a href="view_project?id=' . urlencode($project['id']) . '" class="text-indigo-600 hover:text-indigo-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>';
                                if (isset($_SESSION['role']) && $_SESSION['role'] !== 'View') {
                                    echo '<a href="edit_project?id=' . urlencode($project['id']) . '" class="text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                                        </a>';
                                }
                                if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') {
                                    echo '<button type="button"
                                        class="delete-project-btn text-red-600 hover:text-red-800"
                                        data-project-id="' . htmlspecialchars($project['id'] ?? '') . '">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12.56 0c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                    </button>';
                                }
                            echo '</td>';
                        echo '</tr>';
                    }
                }
            ?>
        </tbody>
    </table>
</div>

<div class="my-6">
    <?php if ($total_pages > 1): ?>
        <nav class="flex items-center justify-between">
            <div class="text-sm text-slate-600">
                Page <?php echo $current_page; ?> of <?php echo $total_pages; ?>
            </div>
            <ul class="inline-flex items-center -space-x-px">
                <?php
                    $pagination_params = $base_link_params;
                    if ($current_page > 1) {
                        $prev_page_params = array_merge($pagination_params, ['page' => $current_page - 1]);
                        echo '<li><a href="manage_projects?' . http_build_query($prev_page_params) . '" class="px-3 py-2 ml-0 leading-tight text-slate-500 bg-white border border-slate-300 rounded-l-lg hover:bg-slate-100 hover:text-slate-700">Previous</a></li>';
                    }
                    $range = 2; $show_ellipsis = false;
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == 1 || $i == $total_pages || ($i >= $current_page - $range && $i <= $current_page + $range)) {
                            if ($show_ellipsis) { echo '<li><span class="px-3 py-2 leading-tight text-slate-500 bg-white border border-slate-300">...</span></li>'; $show_ellipsis = false; }
                            if ($i == $current_page) {
                                echo '<li><span aria-current="page" class="z-10 px-3 py-2 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700">' . $i . '</span></li>';
                            } else {
                                $page_params = array_merge($pagination_params, ['page' => $i]);
                                echo '<li><a href="manage_projects?' . http_build_query($page_params) . '" class="px-3 py-2 leading-tight text-slate-500 bg-white border border-slate-300 hover:bg-slate-100 hover:text-slate-700">' . $i . '</a></li>';
                            }
                        } else { if (!$show_ellipsis) { $show_ellipsis = true; } }
                    }
                    if ($current_page < $total_pages) {
                        $next_page_params = array_merge($pagination_params, ['page' => $current_page + 1]);
                        echo '<li><a href="manage_projects?' . http_build_query($next_page_params) . '" class="px-3 py-2 leading-tight text-slate-500 bg-white border border-slate-300 rounded-r-lg hover:bg-slate-100 hover:text-slate-700">Next</a></li>';
                    }
                ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#filter_status').select2({ width: '100%' });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('table tbody');

        function showNotification(message, type = 'success') {
            const alertContainer = document.querySelector('.flex.justify-between.items-center.mb-6');
            if (!alertContainer) return;

            const alertDiv = document.createElement('div');
            const alertTypeClass = type === 'error' 
                ? 'bg-red-100 border-red-400 text-red-700' 
                : 'bg-green-100 border-green-400 text-green-700';
            
            alertDiv.className = `p-4 mb-4 text-sm rounded-lg border ${alertTypeClass}`;
            alertDiv.setAttribute('role', 'alert');
            alertDiv.innerHTML = message;

            alertContainer.parentNode.insertBefore(alertDiv, alertContainer);

            setTimeout(() => {
                let opacity = 1;
                const fadeInterval = setInterval(function() {
                    if (opacity <= 0.1) {
                        clearInterval(fadeInterval);
                        alertDiv.remove();
                    }
                    alertDiv.style.opacity = opacity;
                    opacity -= opacity * 0.1;
                }, 50);
            }, 5000);
        }

        if (tableBody) {
            tableBody.addEventListener('click', function(event) {
                const deleteButton = event.target.closest('.delete-project-btn');
                const statusButton = event.target.closest('.status-toggle-btn');

                if (deleteButton) {
                    event.preventDefault();

                    if (confirm('Are you sure you want to permanently delete this project?')) {
                        const projectId = deleteButton.dataset.projectId;
                        const tableRow = document.getElementById('project-row-' + projectId);

                        const formData = new FormData();
                        formData.append('id', projectId);

                        fetch('delete_project', { method: 'POST', body: formData })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification(data.message, 'success');

                                tableRow.style.transition = 'opacity 0.5s';
                                tableRow.style.opacity = '0';
                                setTimeout(() => tableRow.remove(), 500);
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An unexpected error occurred. Please check the console.');
                        });
                    }
                }

                if (statusButton) {
                    if (confirm('Are you sure you want to change the status of this project?')) {
                        event.preventDefault();

                        const projectId = statusButton.dataset.projectId;
                        
                        statusButton.disabled = true;

                        fetch('process_edit_project_status', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                            body: JSON.stringify({ project_id: projectId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                statusButton.textContent = data.new_status;
                                
                                const activeClasses = ['bg-green-100', 'text-green-800', 'hover:bg-green-200'];
                                const inactiveClasses = ['bg-slate-200', 'text-slate-800', 'hover:bg-slate-300'];

                                if (data.new_status === 'Active') {
                                    statusButton.classList.remove(...inactiveClasses);
                                    statusButton.classList.add(...activeClasses);
                                } else {
                                    statusButton.classList.remove(...activeClasses);
                                    statusButton.classList.add(...inactiveClasses);
                                }
                            } else {
                                showNotification(data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Fetch error:', error);
                            showNotification('An error occurred while changing status.', 'error');
                        })
                        .finally(() => {
                            statusButton.disabled = false;
                        });
                    }
                }
            });
        }
    });
</script>
