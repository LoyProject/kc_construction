<?php require_once 'header_widget.php'; ?>

<div class="bg-brand-black text-white">

    <div class="w-full overflow-hidden relative">
        <div class="relative w-full">
            <div class="relative w-full mx-auto overflow-hidden aspect-[16/6] max-h-[600px]" id="carousel-images">
            </div>
            <button type="button" id="carousel-prev"
                class="absolute left-1 sm:left-4 top-1/2 -translate-y-1/2 text-white text-xl sm:text-3xl bg-black/40 rounded-full p-1 sm:p-2 hover:bg-black/70 transition z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-8 sm:h-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="sr-only">Previous</span>
            </button>
            <button type="button" id="carousel-next"
                class="absolute right-1 sm:right-4 top-1/2 -translate-y-1/2 text-xl text-brand-green sm:text-3xl bg-black/40 rounded-full p-1 sm:p-2 hover:bg-black/70 transition z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-8 sm:h-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="sr-only">Next</span>
            </button>
            <div class="absolute z-30 flex -translate-x-1/2 bottom-3 sm:bottom-5 left-1/2 space-x-2 sm:space-x-3 rtl:space-x-reverse"
                id="carousel-indicators"></div>
        </div>
    </div>


    <section class="py-16 bg-brand-gray text-center">
        <!-- Heading -->
        <div class="mb-8 text-center">
            <h2 id="achievements-title" class="text-3xl md:text-4xl font-extrabold text-brand-white"></h2>

            <!-- Center Icon with Lines -->
            <div class="flex items-center justify-center my-6">
                <span class="w-16 h-px bg-gray-300"></span>
                <span class="mx-4 text-yellow-500 text-xl">
                    <i class="fa-solid fa-book-open-reader"></i> <!-- or use your house plan icon -->
                </span>
                <span class="w-16 h-px bg-gray-300"></span>
            </div>

            <!-- Subheading -->
            <p id="achievements-subtitle" class="text-brand-white/60 max-w-2xl mx-auto text-sm md:text-base"></p>
        </div>

        <!-- Features -->
        <div id="achievement-items" class="mt-12 pt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-8">
            <!-- Achievement items will be injected here -->
        </div>

        <!-- Button -->
        <div class="mt-12">
            <a href="about_page.php"
                class="bg-brand-gold hover:bg-brand-white text-brand-white hover:text-brand-gold px-6 py-3 font-semibold shadow">
                ABOUT US
            </a>
        </div>
    </section>

    <!-- Types Section -->
    <div id="types-list" class="flex flex-wrap items-center justify-center my-12">
        <!-- Types items will be injected here -->
    </div>

    <!-- product_list -->
    <div class="mx-auto p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8" id="products-list"></div>

    <div class="flex justify-center mt-8 mb-12">
        <a href="about_page.php"
            class="bg-brand-gold hover:bg-brand-white text-brand-white hover:text-brand-gold px-6 py-3 font-semibold shadow transition">
            Load More
        </a>
    </div>

    <!-- Fixed Buttons -->
    <div class="fixed bottom-5 right-5 flex flex-col items-end space-y-3 z-50">
        <!-- Fixed Buttons: Call & Scroll to Top, side by side on desktop, stacked on mobile -->
        <div class="flex items-end sm:items-center space-y-3 space-x-3 sm:space-y-0">
            <!-- Call Button -->
            <a href="https://t.me/sovongdy" target="_blank"
                class="bg-brand-gold text-white font-bold flex items-center p-4 shadow-md hover:bg-white hover:text-brand-gold transition">
                <i class="fab fa-telegram-plane text-sm mr-2"></i>
                Telegram Chat
            </a>

            <!-- Scroll to Top Button -->
            <button id="scrollTopBtn" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
                class="bg-brand-gold text-white p-4 font-bold hover:bg-white hover:text-brand-gold transition hidden">
                <i class="fas fa-arrow-up"></i>
            </button>            
        </div>
    </div>
</div>

<?php require_once 'footer_widget.php'; ?>

<script>
    window.addEventListener('scroll', function () {
        const btn = document.getElementById('scrollTopBtn');
        if (window.scrollY > 300) {
            btn.classList.remove('hidden');
        } else {
            btn.classList.add('hidden');
        }
    });
</script>
