<?php require_once 'header_widget.php'; ?>

<div class="bg-brand-black text-white">

    <!-- Project Page -->
    <div class="w-full mx-auto flex flex-col md:flex-row items-start md:items-center justify-between bg-gray-800 px-4 sm:px-8 md:px-16 lg:px-32 py-6 md:py-8 shadow-md gap-2 md:gap-0">
        <div class="text-sm text-gray-500 flex items-center mb-2 md:mb-0">
            <a href="home_page" class="hover:text-brand-gold font-semibold text-base">Home</a>
            <span class="mx-2">|</span>
            <span class="text-brand-gold font-semibold text-xl">Projects</span>
        </div>
        <h2 class="text-base sm:text-lg md:text-xl font-bold text-brand-white text-left md:text-right">All projects</h2>
    </div>

    <div class="container mt-12 mb-2 mx-auto px-2 sm:px-4 md:px-8">
        <div class="grid grid-cols-1 gap-4 sm:gap-4 md:gap-4 lg:gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">

            <!-- Style Dropdown -->
            <div class="relative w-full z-50">
                <input type="text" placeholder="Style"
                    class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
                    oninput="filterDropdown(this, 'style')" onclick="toggleDropdown('style')" id="dropdownInput-style" />
                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                    <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <ul id="dropdownMenu-style"
                    class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-10">
                    <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'style')">All</li>
                    <li id="dropdown-items-style"></li>
                </ul>
            </div>

            <!-- Type Dropdown -->
            <div class="relative w-full z-50">
                <input type="text" placeholder="Type"
                    class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
                    oninput="filterDropdown(this, 'type')" onclick="toggleDropdown('type')" id="dropdownInput-type" />
                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                    <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <ul id="dropdownMenu-type"
                    class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-10">
                    <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'type')">All</li>
                    <li id="dropdown-items-type"></li>
                </ul>
            </div>

            <!-- Floor Dropdown -->
            <div class="relative w-full z-50">
                <input type="text" placeholder="Floor"
                    class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
                    oninput="filterDropdown(this, 'floor')" onclick="toggleDropdown('floor')" id="dropdownInput-floor" />
                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                    <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <ul id="dropdownMenu-floor"
                    class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-10">
                    <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'floor')">All</li>
                    <li id="dropdown-items-floor"></li>
                </ul>
            </div>

            <!-- Facade Dropdown -->
            <div class="relative w-full z-50">
                <input type="text" placeholder="Facade"
                    class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
                    oninput="filterDropdown(this, 'facade')" onclick="toggleDropdown('facade')" id="dropdownInput-facade" />
                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                    <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <ul id="dropdownMenu-facade"
                    class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-10">
                    <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'facade')">All</li>
                    <li id="dropdown-items-facade"></li>
                </ul>
            </div>

            <!-- Area Dropdown -->
            <div class="relative w-full z-50">
                <input type="text" placeholder="Area"
                    class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
                    oninput="filterDropdown(this, 'area')" onclick="toggleDropdown('area')" id="dropdownInput-area" />
                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                    <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <ul id="dropdownMenu-area"
                    class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-10">
                    <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'area')">All</li>
                    <li id="dropdown-items-area"></li>
                </ul>
            </div>

        </div>
    </div>

    <div id="projects-list" class="mx-auto p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <!-- Example project cards -->
    </div>

    <div class="flex justify-center mt-8 mb-12" id="pagination" data-items-per-page="8">
        <nav class="inline-flex -space-x-px">
            <button class="px-3 py-2 rounded-l bg-brand-gray text-white border border-brand-gray hover:bg-brand-gold hover:text-brand-white" id="prev-page">
                <i class="fas fa-chevron-left"></i>
            </button>
            <span class="px-4 py-2 bg-brand-black text-white border-t border-b border-brand-gray" id="current-page">1</span>
            <button class="px-3 py-2 rounded-r bg-brand-gray text-white border border-brand-gray hover:bg-brand-gold hover:text-brand-white" id="next-page">
                <i class="fas fa-chevron-right"></i>
            </button>
        </nav>
    </div>

    <script>
        // Example JS for client-side pagination (assumes you render all cards in #projects-list)
        const itemsPerPage = 8;
        const projectsList = document.getElementById('projects-list');
        const pagination = document.getElementById('pagination');
        const prevBtn = document.getElementById('prev-page');
        const nextBtn = document.getElementById('next-page');
        const currentPageSpan = document.getElementById('current-page');

        function showPage(page) {
            const cards = projectsList.children;
            const total = cards.length;
            const totalPages = Math.ceil(total / itemsPerPage);
            page = Math.max(1, Math.min(page, totalPages));
            for (let i = 0; i < total; i++) {
                cards[i].style.display = (i >= (page-1)*itemsPerPage && i < page*itemsPerPage) ? '' : 'none';
            }
            currentPageSpan.textContent = page;
            prevBtn.disabled = page === 1;
            nextBtn.disabled = page === totalPages;
        }

        let currentPage = 1;
        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });
        nextBtn.addEventListener('click', () => {
            const total = projectsList.children.length;
            const totalPages = Math.ceil(total / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });

        // Initial call (after cards are rendered)
        document.addEventListener('DOMContentLoaded', () => {
            showPage(1);
        });
    </script>
</div>

<?php require_once 'footer_widget.php'; ?>

<script>
    function toggleDropdown(type) {
        const menu = document.getElementById('dropdownMenu-' + type);
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }

    function selectItem(el, type) {
        const input = document.getElementById('dropdownInput-' + type);
        const menu = document.getElementById('dropdownMenu-' + type);
        if (!input || !menu) {
            console.warn(`Element for type '${type}' not found`);
            return;
        }

        input.value = el.textContent === 'All' ? '' : el.textContent;
        menu.classList.add('hidden');
    }

    function filterDropdown(input, type) {
        const filter = input.value.toLowerCase();
        const items = document.querySelectorAll(`#dropdownMenu-${type} li`);
        items.forEach(item => {
            item.style.display = item.textContent.toLowerCase().includes(filter) ? 'block' : 'none';
        });
    }

    document.addEventListener('click', function (e) {
        ['style', 'type', 'floor', 'facade', 'area'].forEach(type => {
            const input = document.getElementById('dropdownInput-' + type);
            const menu = document.getElementById('dropdownMenu-' + type);
            if (input && menu && !input.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    });
</script>

