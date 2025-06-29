<?php require_once 'header_widget.php'; ?>

<div class="bg-brand-black text-brand-white">

    <!-- About Us Page -->
    <!-- <div
        class="w-full mx-auto flex flex-row items-center justify-between bg-brand-gray px-32 md:px-20 lg:px-32 py-8 shadow-md">
        <div class="text-sm text-gray-500 flex items-center">
            <a href="/" class="hover:text-brand-gold">Home</a>
            <span class="mx-2">|</span>
            <span class="text-brand-gold font-semibold text-xl">About us</span>
        </div>
        <h2 class="text-lg font-semibold text-gray-900 text-right">Who we are?</h2>
    </div> -->
    
    <section class="px-6 md:px-20 lg:px-32 py-16">
        <!-- Our Companies -->
        <div class="mb-12">
            <h3 class="text-xl font-bold mb-2 border-l-4 border-brand-white text-brand-gold pl-2">OUR COMPANIES</h3>
            <p class="mt-4 leading-relaxed">
                <span id="company-profile"></span>
            </p>
        </div>

        <!-- Design Vision -->
        <div>
            <h3 class="text-xl italic font-semibold text-brand-gold mb-2">Design Vision</h3>
            <p class="mt-4 leading-relaxed">
                <span id="vision"></span>
            </p>
        </div>
    </section>
    <script src="js/about_page.js"></script>
    <script src="js/color_config.js"></script>
</div>

<?php require_once 'footer_widget.php'; ?>
