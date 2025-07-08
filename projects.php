<?php require_once 'header.php'; ?>

<div class="bg-brand-black text-white">

    <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="text-center text-white">
            <svg class="animate-spin h-10 w-10 mx-auto text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <p class="mt-4 text-lg">Loading projects...</p>
        </div>
    </div>

    <!-- Project Page -->
    <div class="w-full mx-auto flex flex-col md:flex-row items-start md:items-center justify-between bg-gray-800 px-4 sm:px-8 md:px-16 lg:px-32 py-6 md:py-8 shadow-md gap-2 md:gap-0">
        <div class="text-sm text-gray-500 flex items-center mb-2 md:mb-0">
            <a href="home" class="hover:text-brand-gold font-semibold text-base" data-translate="home"></a>
            <span class="mx-2">|</span>
            <span class="text-brand-gold font-semibold text-xl" data-translate="projects"></span>
        </div>
        <h2 class="text-base sm:text-lg md:text-xl font-bold text-brand-white text-left md:text-right" data-translate="all-projects"></h2>
    </div>

    <div class="container mt-12 mb-2 mx-auto px-2 sm:px-4 md:px-8">
        <div class="grid grid-cols-1 gap-4 sm:gap-4 md:gap-4 lg:gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">

            <!-- Style Dropdown -->
            <div class="relative w-full z-20">
                <input type="text" placeholder="Style" data-translate="style"
                    class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
                    oninput="filterDropdown(this, 'style')" onclick="toggleDropdown('style')" id="dropdownInput-style" />
                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                    <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <ul id="dropdownMenu-style"
                    class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-10">
                    <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'style')" data-translate="load-all">All</li>
                    <li id="dropdown-items-style"></li>
                </ul>
            </div>

            <!-- Type Dropdown -->
            <div class="relative w-full z-20">
                <input type="text" placeholder="Type" data-translate="type"
                    class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
                    oninput="filterDropdown(this, 'type')" onclick="toggleDropdown('type')" id="dropdownInput-type" />
                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                    <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <ul id="dropdownMenu-type"
                    class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-10">
                    <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'type')" data-translate="load-all">All</li>
                    <li id="dropdown-items-type"></li>
                </ul>
            </div>

            <!-- Floor Dropdown -->
            <div class="relative w-full z-20">
                <input type="text" placeholder="Floor" data-translate="floor"
                    class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
                    oninput="filterDropdown(this, 'floor')" onclick="toggleDropdown('floor')" id="dropdownInput-floor" />
                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                    <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <ul id="dropdownMenu-floor"
                    class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-10">
                    <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'floor')" data-translate="load-all">All</li>
                    <li id="dropdown-items-floor"></li>
                </ul>
            </div>

            <!-- Facade Dropdown -->
            <div class="relative w-full z-20">
                <input type="text" placeholder="Facade" data-translate="facade"
                    class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
                    oninput="filterDropdown(this, 'facade')" onclick="toggleDropdown('facade')" id="dropdownInput-facade" />
                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                    <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <ul id="dropdownMenu-facade"
                    class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-10">
                    <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'facade')" data-translate="load-all">All</li>
                    <li id="dropdown-items-facade"></li>
                </ul>
            </div>

            <!-- Area Dropdown -->
            <div class="relative w-full z-20">
                <input type="text" placeholder="<?php echo htmlspecialchars($translations['area'] ?? 'Area'); ?>" data-translate="area"
                    class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
                    oninput="filterDropdown(this, 'area')" onclick="toggleDropdown('area')" id="dropdownInput-area" />
                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                    <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <ul id="dropdownMenu-area"
                    class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-10">
                    <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'area')" data-translate="load-all">All</li>
                    <li id="dropdown-items-area"></li>
                </ul>
            </div>

        </div>
    </div>

    <div id="list" class="mx-auto p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <!-- Example project cards -->
    </div>

    <div id="pagination-container" class="flex flex-wrap justify-center mx-auto px-8 mt-4 mb-12 gap-2 text-base"></div>
</div>

<?php require_once 'footer.php'; ?>

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
        if (!input || !menu) return;

        const label = el.textContent;
        const id = el.getAttribute('data-id');

        if (label === 'All' || label === 'ទាំងអស់') {
            input.value = '';
            input.removeAttribute('data-id');
        } else {
            input.value = label;
            input.setAttribute('data-id', id);
        }

        menu.classList.add('hidden');
        loadProjects(1);    
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

    $(document).ready(function () {
        const typeId = sessionStorage.getItem('selectedTypeId');
        const typeLabel = sessionStorage.getItem('selectedTypeLabel');

        if (typeId && typeLabel) {
            const $typeInput = $('#dropdownInput-type');

            if ($typeInput.length) {
                $typeInput.val(typeLabel);
                $typeInput.attr('data-id', typeId);
            }

            sessionStorage.removeItem('selectedTypeId');
            sessionStorage.removeItem('selectedTypeLabel');

            loadProjects(1);
        } else {
            loadProjects(1);
        }
    });
</script>
