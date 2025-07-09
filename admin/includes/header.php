<?php
    require_once 'includes/db_connect.php';

    $companyLogo = 'assets/images/companies/default_logo.png';

    try {
        $stmt = $pdo->query("SELECT logo, name FROM companies ORDER BY id DESC LIMIT 1");
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $companyName = htmlspecialchars($row['name'] ?? '');
            if (!empty($row['logo'])) {
                $companyLogo = htmlspecialchars($row['logo'] ?? '');
            }
        }
    } catch (Exception $e) {
        error_log("Error fetching company logo: " . $e->getMessage());
        $companyLogo = 'assets/images/companies/default_logo.png';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title ?? '') . ' - ' . $companyName : 'Loy Team'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-blue': '#1E40AF',
                        'brand-green': '#16A34A',
                        'brand-black': '#000000',
                        'brand-white': '#F9FAFB',
                        'brand-gold': '#f5b041',
                        'brand-gray': '#101720',
                    }
                }
            },
            safelist: [
                'font-bold',
                'font-semibold',
                'text-slate-700',
                'bg-red-100',
                'border-red-400',
                'text-red-700',
                'bg-green-100',
                'border-green-400',
                'text-green-700'
            ],   
        }
    </script>
    <link href="assets/css/custom_styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex min-h-screen bg-gray-100">
    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['username'])): ?>
        <aside class="w-64 bg-black text-white min-h-screen px-4 pb-4 pt-2">
            <div class="mb-2 flex items-center space-x-3">
                <a href="index"><img src="<?php echo htmlspecialchars($companyLogo ?? ''); ?>" alt="KC Construction & Design Logo" class="w-16 h-16 bg-gray-800 rounded-full object-cover"></a>
                <div class="flex-1">
                    <h2 class="text-base text-brand-gold font-semibold truncate"><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></h2>
                    <p class="text-xs text-gray-400 truncate"><?php echo htmlspecialchars($_SESSION['role'] ?? ''); ?></p>
                </div>
            </div>
            <nav>
                <ul class="space-y-2 border-t pt-2 border-gray-700">
                    <li><a href="manage_projects" class="block px-4 py-2 rounded hover:bg-gray-700">Projects</a></li>
                    <?php if ($_SESSION['role'] !== 'View'): ?>
                        <li><a href="manage_companies" class="block px-4 py-2 rounded hover:bg-gray-700">Companies</a></li>
                        <li><a href="manage_achievements" class="block px-4 py-2 rounded hover:bg-gray-700">Achievements</a></li>
                        <li><a href="manage_users" class="block px-4 py-2 rounded hover:bg-gray-700">Users</a></li>                
                    <?php endif; ?>
                    <li><a href="manage_requests" class="block px-4 py-2 rounded hover:bg-gray-700">Requests</a></li>
                    <?php if ($_SESSION['role'] !== 'View'): ?>
                        <li x-data="{ open: false }">
                            <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 rounded hover:bg-gray-700">
                                <span>Settings</span>
                                <svg :class="{'rotate-180': open}" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <ul x-show="open" x-transition x-cloak class="pl-4 space-y-1 mt-1">
                                <li><a href="manage_styles" class="block px-4 py-2 rounded hover:bg-gray-700">Styles</a></li>
                                <li><a href="manage_types" class="block px-4 py-2 rounded hover:bg-gray-700">Types</a></li>
                                <li><a href="manage_floors" class="block px-4 py-2 rounded hover:bg-gray-700">Floors</a></li>
                                <li><a href="manage_facades" class="block px-4 py-2 rounded hover:bg-gray-700">Facades</a></li>
                                <li><a href="manage_areas" class="block px-4 py-2 rounded hover:bg-gray-700">Areas</a></li>
                                <li><a href="manage_sizes" class="block px-4 py-2 rounded hover:bg-gray-700">Sizes</a></li>
                                <li><a href="manage_addresses" class="block px-4 py-2 rounded hover:bg-gray-700">Address</a></li>
                            </ul>
                        </li> 
                    <?php endif; ?>
                    <li><a href="../index" target="_blank" class="block px-4 py-2 rounded hover:bg-gray-700 mt-6 border-t border-gray-700 pt-4">View Public Site</a></li>
                    <li><a href="logout" class="block px-4 py-2 rounded hover:bg-red-500">Logout</a></li>
                </ul>
            </nav>
        </aside>
    <?php endif; ?>

    <div class="flex flex-col flex-1">
        <main class="flex-1 container mx-auto p-6 flex-grow">
            <?php if (isset($_SESSION['message'])): ?>
                <div id="alertMessage" class="mb-4 p-4 rounded-md <?php echo ($_SESSION['message_type'] ?? 'success') == 'error' ? 'bg-red-100 border-red-400 text-red-700' : 'bg-green-100 border-green-400 text-green-700'; ?>" role="alert">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); ?>
                <?php unset($_SESSION['message_type']); ?>
            <?php endif; ?>
        