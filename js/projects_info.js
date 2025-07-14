function loadProjects(page = 1) {
    const style = $('#dropdownInput-style').attr('data-id') || '';
    const type = $('#dropdownInput-type').attr('data-id') || '';
    const floor = $('#dropdownInput-floor').attr('data-id') || '';
    const area = $('#dropdownInput-area').attr('data-id') || '';
    const facade = $('#dropdownInput-facade').attr('data-id') || '';

    $.ajax({
        url: 'backend/process_fetch_projects.php',
        method: 'GET',
        data: { page: page, limit: 16, style: style, type: type, floor: floor, area: area, facade: facade },
        dataType: 'json',
        beforeSend: function() {
            $('html, body').stop().animate({ scrollTop: 0 }, 300);
            $('#loading-overlay').removeClass('hidden');
        },
        success: function(data) {   
            const projectsList = $('#list');
            const paginationContainer = $('#pagination-container');
            projectsList.empty();
            paginationContainer.empty();

            if (data.success) {
                data.projects.forEach(function(project) {
                    const isNew = (() => {
                        const createdAt = new Date(project.created_at);
                        const now = new Date();
                        const diffDays = (now - createdAt) / (1000 * 60 * 60 * 24);
                        return diffDays < 30;
                    })();

                    const formatCurrency = (amount) => {
                        if (!amount) return '';
                        return Number(amount).toLocaleString('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 0 });
                    };

                    const projectItem = ` 
                        <div class="project-card bg-brand-gray text-white shadow hover:shadow-lg flex flex-col overflow-hidden">
                            <div class="relative group cursor-pointer">
                                <div class="w-full aspect-[4/3] overflow-hidden">
                                    <img src="admin/${project.image_path}" alt="${project.name}" 
                                    class="w-full h-full object-cover transition-opacity duration-300" />
                                </div>

                                ${isNew ? `<span class="absolute top-0 left-0 bg-brand-gold text-brand-white text-xs font-semibold px-3 py-1 rounded-br-lg z-10" data-translate="new">New</span>` : ''}
                                <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <a href="projects_detail?id=${project.id}" class="border border-white p-2 flex items-center justify-center hover:bg-brand-gold hover:border-brand-gold transition-colors duration-300">
                                        <i class="fas fa-link text-white text-xl"></i> 
                                    </a>
                                </div>
                            </div>
                            <div class="project-info p-4">
                                <p class="truncate whitespace-nowrap overflow-hidden text-base font-bold text-brand-gold" title="${project.name}">${project.name}</p>
                                <ul class="mt-2 text-sm text-brand-white">
                                    <li class="flex gap-2 mt-1 items-center">
                                        <span class="flex items-center"><i class="fa-solid fa-eye text-brand-gold w-4 h-4"></i></span>
                                        <span class="flex items-center"><span data-translate="view"></span></span>
                                        <span>${project.view || ''}</span>
                                    </li>
                                    <li class="flex gap-2 mt-1 items-center">
                                        <span class="flex items-center"><i class="fas fa-money-bill-wave text-brand-gold w-4 h-4"></i></span>
                                        <span class="flex items-center"><span data-translate="budget">Budget:</span></span>
                                        <span>${formatCurrency(project.budget)}</span>
                                    </li>
                                    <li class="flex gap-2 mt-1 items-center">
                                        <span class="flex items-center"><i class="fas fa-ruler-combined text-brand-gold w-4 h-4"></i></span>
                                        <span class="flex items-center"><span data-translate="size-card">Size:</span></span>
                                        <span>${project.size.name || ''}</span>
                                    </li>
                                    <li class="flex gap-2 mt-1 items-center">
                                        <span class="flex items-center"><i class="fas fa-map text-brand-gold w-4 h-4"></i></span>
                                        <span class="flex items-center"><span data-translate="area">Area:</span></span>
                                        <span>${project.area.name || ''}</span>
                                    </li>
                                    <li class="flex gap-2 mt-1 items-center">
                                        <span class="flex items-center"><i class="fas fa-location-dot text-brand-gold w-4 h-4"></i></span>
                                        <span class="flex items-center"><span data-translate="location-card">Location:</span></span>
                                        <span>${project.address.name || ''}</span>
                                    </li>
                                </ul>
                            </div>
                        </div> `;
                    projectsList.append(projectItem);
                });

                const { page, pages } = data.pagination;
                const maxPagesToShow = 1;

                const createBtn = (label, targetPage, disabled = false, active = false) => {
                    return $(`<button class="px-4 py-2 rounded ${active ? 'bg-brand-gold text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'} ${disabled ? 'opacity-50 cursor-not-allowed' : ''} text-xs sm:text-sm"} ${disabled ? 'disabled' : ''}>${label}</button>`)
                        .click(() => {
                            if (!disabled && targetPage !== page) loadProjects(targetPage);
                        });
                };

                paginationContainer.append(createBtn('«', page - 1, page === 1));

                paginationContainer.append(createBtn('1', 1, false, page === 1));
                if (page - maxPagesToShow > 2) {
                    paginationContainer.append($('<span class="px-1 text-gray-500 hidden sm:inline">...</span>'));
                }

                let start = Math.max(2, page - maxPagesToShow);
                let end = Math.min(pages - 1, page + maxPagesToShow);
                for (let i = start; i <= end; i++) {
                    paginationContainer.append(createBtn(i, i, false, i === page));
                }

                if (page + maxPagesToShow < pages - 1) {
                    paginationContainer.append($('<span class="px-1 text-gray-500 hidden sm:inline">...</span>'));
                }

                if (pages > 1) {
                    paginationContainer.append(createBtn(pages, pages, false, page === pages));
                }

                paginationContainer.append(createBtn('»', page + 1, page === pages));
            } else {
                console.error('Failed to fetch projects:', data.message);
            }

            const lang = localStorage.getItem('lang') || 'en';
            if (typeof applyLang === "function") {
                applyLang(lang);
            }

            $('#loading-overlay').addClass('hidden');
            setTimeout(() => { $('html, body').stop().animate({ scrollTop: 0 }, 300); }, 50);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching projects:', textStatus, errorThrown);
            $('#loading-overlay').addClass('hidden');
        }
    });
}

$(document).ready(function() {
    loadProjects(1);
});
