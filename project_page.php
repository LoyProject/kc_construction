<?php require_once 'header_widget.php'; ?>

<div class="bg-brand-black text-white">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
            <select class="bg-brand-gray border border-brand-gray px-4 py-6">
                <option>Style</option>
            </select>
            <select class="bg-brand-gray border border-brand-gray px-4 py-6">
                <option>Type</option>
            </select>
            <select class="bg-brand-gray border border-brand-gray px-4 py-6">
                <option>Number of floor</option>
            </select>
            <select class="bg-brand-gray border border-brand-gray px-4 py-6">
                <option>Facades</option>
            </select>
            <select class="bg-brand-gray border border-brand-gray px-4 py-6">
                <option>Floor area</option>
            </select>
        </div>
    </div>

    <div id="projects-list" class="mx-auto p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
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
