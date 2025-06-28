<?php
    session_start();
    $page_title = "Login";
    require_once 'includes/functions.php';
    require_once 'includes/header.php';

    if (isset($_SESSION['user_id'])) {
        header("Location: index");
        exit;
    }

    if (isset($_SESSION['message'])): ?>
        <div class="p-4 mb-4 text-sm <?php echo ($_SESSION['message_type'] == 'error') ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'; ?> rounded-lg" role="alert">
            <?php echo $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message']); ?>
        <?php unset($_SESSION['message_type']); ?>
    <?php endif; 
?>

<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6 text-brand-blue">Login to Your Account</h1>

    <form action="process_login" method="POST">        
        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-slate-700 mb-1">Username <span class="text-red-500">*</span></label>
            <input type="text" name="username" id="username" required
                class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
        </div>
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password <span class="text-red-500">*</span></label>
            <div class="relative">
                <input id="toggle-password" type="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                <button type="button" id="toggle-password-btn"
                    class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-blue-600">
                    <svg id="eye-icon" class="shrink-0 size-3.5" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path id="eye" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                        <circle id="pupil" cx="12" cy="12" r="3"></circle>
                        <line id="slash" x1="2" y1="2" x2="22" y2="22" style="display:none;"></line>
                    </svg>
                </button>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" name="submit_login" class="bg-brand-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-sm w-full">Log In</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>

<script>
    const passwordInput = document.getElementById('toggle-password');
    const toggleBtn = document.getElementById('toggle-password-btn');
    const eye = document.getElementById('eye');
    const pupil = document.getElementById('pupil');
    const slash = document.getElementById('slash');

    toggleBtn.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            slash.style.display = 'block';
            eye.style.opacity = '0.5';
            pupil.style.opacity = '0.5';
        } else {
            passwordInput.type = 'password';
            slash.style.display = 'none';
            eye.style.opacity = '1';
            pupil.style.opacity = '1';
        }
    });
</script>
