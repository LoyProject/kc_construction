<?php require_once 'header.php'; ?>

<div class="bg-brand-black text-white">

    <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="text-center text-white">
            <svg class="animate-spin h-10 w-10 mx-auto text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <p class="mt-4 text-lg">Loading projects...</p>
        </div>
    </div>

    <div class="container mx-auto p-8 sm:p-4 grid grid-cols-1 gap-4 sm:gap-4 md:gap-4 lg:gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">

        <div class="relative w-full z-0">
            <input type="text" placeholder="Style" data-translate="style"
            class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
            oninput="filterDropdown(this, 'style')" 
            onclick="toggleDropdown('style'); this.parentElement.classList.add('z-20');" 
            onblur="setTimeout(() => this.parentElement.classList.remove('z-20'), 200);" 
            id="dropdownInput-style" />
            <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
            <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            </div>

            <ul id="dropdownMenu-style"
            class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-40">
            <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'style')"
            data-translate="load-all">All</li>
            <div id="dropdown-items-style"></div>
            </ul>
        </div>

        <div class="relative w-full z-0">
            <input type="text" placeholder="Type" data-translate="type"
            class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
            oninput="filterDropdown(this, 'type')" 
            onclick="toggleDropdown('type'); this.parentElement.classList.add('z-20');" 
            onblur="setTimeout(() => this.parentElement.classList.remove('z-20'), 200);" 
            id="dropdownInput-type" />
            <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
            <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            </div>

            <ul id="dropdownMenu-type"
            class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-30">
            <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'type')"
            data-translate="load-all">All</li>
            <div id="dropdown-items-type"></div>
            </ul>
        </div>

        <div class="relative w-full z-0">
            <input type="text" placeholder="Floor" data-translate="floor-dropdown"
            class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
            oninput="filterDropdown(this, 'floor')" 
            onclick="toggleDropdown('floor'); this.parentElement.classList.add('z-20');" 
            onblur="setTimeout(() => this.parentElement.classList.remove('z-20'), 200);" 
            id="dropdownInput-floor" />
            <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
            <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            </div>

            <ul id="dropdownMenu-floor"
            class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-20">
            <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'floor')"
            data-translate="load-all">All</li>
            <div id="dropdown-items-floor"></div>
            </ul>
        </div>

        <div class="relative w-full z-0">
            <input type="text" placeholder="Facade" data-translate="facade"
            class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
            oninput="filterDropdown(this, 'facade')" 
            onclick="toggleDropdown('facade'); this.parentElement.classList.add('z-20');" 
            onblur="setTimeout(() => this.parentElement.classList.remove('z-20'), 200);" 
            id="dropdownInput-facade" />
            <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
            <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            </div>

            <ul id="dropdownMenu-facade"
            class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-10">
            <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'facade')"
            data-translate="load-all">All</li>
            <div id="dropdown-items-facade"></div>
            </ul>
        </div>

        <div class="relative w-full z-0">
            <input type="text" placeholder="<?php echo htmlspecialchars($translations['area'] ?? 'Area'); ?>"
            data-translate="area-dropdown"
            class="w-full bg-brand-black border border-gray-300 px-3 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold text-brand-white"
            oninput="filterDropdown(this, 'area')" 
            onclick="toggleDropdown('area'); this.parentElement.classList.add('z-20');" 
            onblur="setTimeout(() => this.parentElement.classList.remove('z-20'), 200);" 
            id="dropdownInput-area" />
            <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
            <svg class="h-4 w-4 text-brand-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            </div>

            <ul id="dropdownMenu-area"
            class="absolute w-full bg-brand-black border border-gray-300 mt-1 max-h-48 overflow-y-auto hidden z-10">
            <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'area')"
            data-translate="load-all">All</li>
            <div id="dropdown-items-area"></div>
            </ul>
        </div>

    </div>

    <div id="list" class="container mx-auto p-8 sm:p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8"></div>

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