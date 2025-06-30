$(document).ready(function() {
    $.ajax({
        url: 'backend/process_fetch_projects.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const projectsList = $('#projects-list');
            projectsList.empty();

            if (data.success) {
                data.projects.forEach(function(project) {
                    const isNew = (() => {
                        const createdAt = new Date(project.created_at);
                        const now = new Date();
                        const diffMs = now - createdAt;
                        const diffDays = diffMs / (1000 * 60 * 60 * 24);
                        return diffDays < 30; // Check if the project is less than 30 days old
                    })();

                    const projectItem = `
                        <div class="project-card bg-brand-gray text-white shadow hover:shadow-lg flex flex-col overflow-hidden">
                            <div class="relative group cursor-pointer">
                                <img src="admin/${project.image_path}" alt="${project.name}" class="w-full h-48 transition-opacity duration-300" />
                                ${isNew ? `<span class="absolute top-0 left-0 bg-brand-gold text-brand-white text-xs font-semibold px-3 py-1 rounded-br-lg z-10">New</span>` : ''}
                                <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <a href="project_detail_page?id=${project.id}" class="border border-white p-2 flex items-center justify-center hover:bg-brand-gold hover:border-brand-gold transition-colors duration-300">
                                        <i class="fas fa-link text-white text-xl"></i> 
                                    </a>
                                </div>
                            </div>
                            <div class="project-info p-4">
                                <p class="truncate whitespace-nowrap overflow-hidden text-base font-bold text-brand-gold" title="${project.name}">${project.name}</p>
                                <ul class="mt-2 text-sm text-brand-white">
                                    <li class="flex gap-2 mt-1 items-center">
                                        <span class="flex items-center"><i class="fa-solid fa-eye text-brand-gold w-4 h-4"></i></span>
                                        <span class="flex items-center"><p class="m-0">View:</p></span>
                                        <span>${project.view || ''}</span>
                                    </li>
                                    <li class="flex gap-2 mt-1 items-center">
                                        <span class="flex items-center"><i class="fas fa-user text-brand-gold w-4 h-4"></i></span>
                                        <span class="flex items-center"><p class="m-0">Investor:</p></span>
                                        <span>${project.investor || ''}</span>
                                    </li>
                                    <li class="flex gap-2 mt-1 items-center">
                                        <span class="flex items-center"><i class="fas fa-map-marker-alt text-brand-gold w-4 h-4"></i></span>
                                        <span class="flex items-center"><p class="m-0">Address:</p></span>
                                        <span>${project.address.name || ''}</span>
                                    </li>
                                    <li class="flex gap-2 mt-1 items-center">
                                        <span class="flex items-center"><i class="fas fa-ruler-combined text-brand-gold w-4 h-4"></i></span>
                                        <span class="flex items-center"><p class="m-0">Area:</p></span>
                                        <span>${project.area.name || ''}</span>
                                    </li>
                                    <li class="flex gap-2 mt-1 items-center">
                                        <span class="flex items-center"><i class="fas fa-layer-group text-brand-gold w-4 h-4"></i></span>
                                        <span class="flex items-center"><p class="m-0">Number of floors:</p></span>
                                        <span>${project.floor.name || ''}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    `;
                    projectsList.append(projectItem);
                });
            } else {
                console.error('Failed to fetch projects:', data.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching projects:', textStatus, errorThrown);
        }
    });
});
