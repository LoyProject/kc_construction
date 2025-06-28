<?php require_once 'functions.php'; ?>

        </main>

        <footer class="bg-white text-slate-600 text-center p-4 print:hidden">
            <b>&copy; <?php echo date("Y"); ?> Loy Team. All rights reserved.</b>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alertMessage = document.getElementById('alertMessage');

            if (alertMessage) {
                setTimeout(function() {
                    let opacity = 1;
                    const fadeInterval = setInterval(function() {
                        if (opacity <= 0.1) {
                            clearInterval(fadeInterval);
                            alertMessage.style.display = 'none';
                        }
                        alertMessage.style.opacity = opacity;
                        opacity -= opacity * 0.1;
                    }, 50);
                }, 3000);
            }
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html>
