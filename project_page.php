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

    <div class="flex justify-center mt-8 mb-12" id="pagination">
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
</div>

<?php require_once 'footer_widget.php'; ?>
