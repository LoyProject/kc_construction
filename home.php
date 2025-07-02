<?php require_once 'header.php'; ?>

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
        <div class="mb-8 text-center">
            <h2 id="achievements-title" class="text-3xl md:text-4xl font-extrabold text-brand-white"></h2>

            <div class="flex items-center justify-center my-6">
                <span class="w-16 h-px bg-gray-300"></span>
                <span class="mx-4 text-yellow-500 text-xl">
                    <i class="fa-solid fa-book-open-reader"></i>
                </span>
                <span class="w-16 h-px bg-gray-300"></span>
            </div>

            <p id="achievements-subtitle" class="text-brand-white/60 max-w-2xl mx-auto text-sm md:text-base"></p>
        </div>

        <div id="achievement-items" class="mt-12 pt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-8"></div>

        <div class="mt-12">
            <a href="about"
                class="bg-brand-gold hover:bg-brand-white text-brand-white hover:text-brand-gold px-6 py-3 font-semibold shadow"
                x-text="lang === 'en' ? 'ABOUT US' : 'អំពីយើង'">
            </a>
        </div>
    </section>

    <div id="types-list" class="flex flex-wrap items-center justify-center my-12"></div>

    <div class="mx-auto p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <div class="project-card bg-brand-gray text-white shadow hover:shadow-lg flex flex-col overflow-hidden">
            <div class="relative group cursor-pointer">
                <img id="project-image" alt="${project.name}"
                    class="w-full h-48 transition-opacity duration-300" />
                <span
                    class="absolute top-0 left-0 bg-brand-gold text-brand-white text-xs font-semibold px-3 py-1 rounded-br-lg z-10"
                    x-text="lang === 'en' ? 'New' : 'ទំព័រដើម'">
                </span>
                <div
                    class="absolute inset-0 bg-black bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <a href="projects_detail?id=${project.id}"
                        class="border border-white p-2 flex items-center justify-center hover:bg-brand-gold hover:border-brand-gold transition-colors duration-300">
                        <i class="fas fa-link text-white text-xl"></i>
                    </a>
                </div>
            </div>
            <div class="project-info p-4">
                <p id="project-title" class="truncate whitespace-nowrap overflow-hidden text-base font-bold text-brand-gold"
                    ></p>
                <ul class="mt-2 text-sm text-brand-white">
                    <li class="flex gap-2 mt-1 items-center">
                        <span class="flex items-center"><i class="fa-solid fa-eye text-brand-gold w-4 h-4"></i></span>
                        <span class="flex items-center">
                            <p class="m-0">View:</p>
                        </span>
                        <span></span>
                    </li>
                    <li class="flex gap-2 mt-1 items-center">
                        <span class="flex items-center"><i class="fas fa-user text-brand-gold w-4 h-4"></i></span>
                        <span class="flex items-center">
                            <p class="m-0">Investor:</p>
                        </span>
                        <span></span>
                    </li>
                    <li class="flex gap-2 mt-1 items-center">
                        <span class="flex items-center"><i
                                class="fas fa-map-marker-alt text-brand-gold w-4 h-4"></i></span>
                        <span class="flex items-center">
                            <p class="m-0">Address:</p>
                        </span>
                        <span></span>
                    </li>
                    <li class="flex gap-2 mt-1 items-center">
                        <span class="flex items-center"><i
                                class="fas fa-ruler-combined text-brand-gold w-4 h-4"></i></span>
                        <span class="flex items-center">
                            <p class="m-0">Area:</p>
                        </span>
                        <span></span>
                    </li>
                    <li class="flex gap-2 mt-1 items-center">
                        <span class="flex items-center"><i
                                class="fas fa-layer-group text-brand-gold w-4 h-4"></i></span>
                        <span class="flex items-center">
                            <p class="m-0">Number of floors:</p>
                        </span>
                        <span></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="flex justify-center mt-8 mb-12">
        <a href="projects"
            class="bg-brand-gold hover:bg-brand-white text-brand-white hover:text-brand-gold px-6 py-3 font-semibold shadow transition">
            <span x-text="lang === 'en' ? 'Load More' : 'មើលបន្ថែម'"></span>
        </a>
    </div>

    <div class="fixed bottom-5 right-5 flex flex-col items-end space-y-3 z-50">
        <div class="flex items-end sm:items-center space-y-3 space-x-3 sm:space-y-0">
            <a id="telegram-link-button" target="_blank"
                class="bg-brand-gold text-white font-bold flex items-center p-4 shadow-md hover:bg-white hover:text-brand-gold transition">
            </a>
            <button id="scrollTopBtn" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
                class="bg-brand-gold text-white p-4 font-bold hover:bg-white hover:text-brand-gold transition hidden">
                <i class="fas fa-arrow-up"></i>
            </button>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>

<script>
    window.addEventListener('scroll', function () {
        const btn = document.getElementById('scrollTopBtn');
        if (window.scrollY > 300) {
            btn.classList.remove('hidden');
        } else {
            btn.classList.add('hidden');
        }
    });

    $(document).on('click', '.type-item', function () {
        const selectedTypeName = $(this).text().trim();
        const selectedTypeId = $(this).attr('data-id');

        if (selectedTypeId && selectedTypeId !== 'all') {
            sessionStorage.setItem('selectedTypeId', selectedTypeId);
            sessionStorage.setItem('selectedTypeLabel', selectedTypeName);
            window.location.href = 'projects';
        }
    });
</script>