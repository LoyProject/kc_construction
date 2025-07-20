<?php require_once 'header.php'; ?>

<div class="container mx-auto bg-brand-black text-brand-white">

    <div id="loading-overlay-about" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="text-center text-white">
            <svg class="animate-spin h-10 w-10 mx-auto text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <p class="mt-4 text-lg">Loading...</p>
        </div>
    </div>
    
    <section class="py-4">
        <!-- Our Companies -->
        <div class="mx-auto px-8 py-4 sm:p-4 mb-12">
            <div class="flex justify-center mb-8">
                <img id="company-profile-image" alt="About Us" class="max-w-full h-auto">
            </div>

            <h3 class="text-xl font-bold mb-2 border-l-4 border-brand-white text-brand-gold pl-2" data-translate="our-companies">OUR COMPANIES</h3>
            <p class="mt-4 leading-relaxed">
                <span id="company-profile" class="text-justify"></span>
            </p>
        </div>
        <!-- Design Vision -->
        <div class="mx-auto px-8 py-4 sm:p-4 mb-12">
            <div class="flex justify-center mb-8">
            <img id="company-vision-image" alt="About Us" class="max-w-full h-auto">
        </div>
            <h3 class="text-xl font-bold mb-2 border-l-4 border-brand-white text-brand-gold pl-2" data-translate="vision">Design Vision</h3>
            <p class="mt-4 leading-relaxed">
                <span id="company-vision"></span>
            </p>
        </div>
    </section>

    <div class="mt-12"></div>
</div>

<?php require_once 'footer.php'; ?>
