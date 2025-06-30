$(document).ready(function() {
    const projectId = new URLSearchParams(window.location.search).get('id');

    if (projectId) {
        $.ajax({
            url: 'backend/process_fetch_projects_detail.php',
            type: 'POST',
            data: { id: projectId },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    const project = data.project;
                    $('#project-detail').html(`
                        <div class="bg-brand-black text-white">
                            <main class="p-4 sm:p-6 md:p-12">
                                <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">

                                    <!-- Left: Main image and thumbnails -->
                                    <div class="w-full lg:w-2/3">
                                        <img src="admin/${project.image_path}" class="shadow mb-4 w-full max-h-[300px] sm:max-h-[400px] md:max-h-[500px] lg:max-h-[600px] fit-cover"/>

                                        <div class="flex gap-2 overflow-x-auto pb-2">
                                            ${
                                                (
                                                    Array.isArray(project.images)
                                                        ? project.images
                                                        : (typeof project.images === 'string' && project.images.trim() !== '')
                                                            ? JSON.parse(project.images)
                                                            : []
                                                ).map((item, i) => `
                                                    <img src="admin/${item.image_path}" alt="Thumb ${i+1}"
                                                        class="w-20 h-14 sm:w-24 sm:h-16 md:w-28 md:h-20 fit-cover shadow"/>
                                                `).join('')
                                            }
                                        </div>
                                    </div>

                                    <!-- Right: Filter Buttons -->
                                    <div class="w-full lg:w-1/3 space-y-6">
                                        <div>
                                            <h2 class="text-base sm:text-lg font-semibold mb-2 border-b pb-1 border-yellow-500 inline-block">
                                                FLOOR NUMBER
                                            </h2>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                                <button class="bg-brand-gray px-3 py-2 hover:bg-yellow-500 hover:text-white text-xs sm:text-sm">1 floor</button>
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">2 floors</button>
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">3 floors</button>
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">4 floors</button>
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">11 floors</button>
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">18 floors</button>
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">19 floors</button>
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">21 floors</button>
                                            </div>
                                        </div>

                                        <div>
                                            <h2 class="text-base sm:text-lg font-semibold mb-2 border-b pb-1 border-yellow-500 inline-block">
                                                FACADE</h2>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">7m - 8m</button>
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">9m - 10m</button>
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">11m - 12m</button>
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">12m - 13m</button>
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">13m - 14m</button>
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">Over 15m</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Title -->
                                <div class="mt-6 sm:mt-8 md:mt-10">
                                    <h1 class="text-lg sm:text-xl md:text-2xl font-semibold text-brand-gold">${project.name}</h1>
                                </div>

                                <!-- Info Table -->
                                <div class="mt-4 sm:mt-6">
                                    <h2 class="text-base sm:text-lg font-bold border-b border-brand-gold inline-block mb-3 sm:mb-4">GENERAL INFOMATIONS</h2>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full border border-brand-gray text-xs sm:text-sm">
                                            <tbody class="divide-y divide-brand-gray">
                                                <tr class="border border-brand-gray">
                                                    <td class="flex items-center gap-2 p-2 sm:p-3 min-w-[100px]">
                                                        <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                                            <i class="fas fa-eye text-brand-gold"></i>
                                                        </span>
                                                        View
                                                    </td>
                                                    <td class="p-2 sm:p-3 min-w-[80px] border border-brand-gray">${project.view || 0}</td>
                                                    <td class="flex items-center gap-2 p-2 sm:p-3 min-w-[100px]">
                                                        <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                                            <i class="fas fa-user text-brand-gold"></i>
                                                        </span>
                                                        Investor
                                                    </td>
                                                    <td class="p-2 sm:p-3 min-w-[80px] border border-brand-gray">${project.investor || ''}</td>
                                                </tr>
                                                <tr class="border-b border-brand-gray">
                                                    <td class="flex items-center gap-2 p-2 sm:p-3 min-w-[100px]">
                                                        <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                                            <i class="fas fa-bullseye text-brand-gold"></i>
                                                        </span>
                                                        Style
                                                    </td>
                                                    <td class="p-2 sm:p-3 min-w-[80px] border border-brand-gray">${project.style.name || ''}</td>
                                                    <td class="flex items-center gap-2 p-2 sm:p-3 min-w-[100px]">
                                                        <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                                            <i class="fas fa-cogs text-brand-gold"></i>
                                                        </span>
                                                        Total Area
                                                    </td>
                                                    <td class="p-2 sm:p-3 min-w-[80px] border border-brand-gray">${project.area.name || ''}</td>
                                                </tr>
                                                <tr class="border-b border-brand-gray">
                                                    <td class="flex items-center gap-2 p-2 sm:p-3 min-w-[100px]">
                                                        <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                                            <i class="fas fa-chart-bar text-brand-gold"></i>
                                                        </span>
                                                        Number of floor
                                                    </td>
                                                    <td class="p-2 sm:p-3 min-w-[80px] border border-brand-gray">${project.floor.name || ''}</td>
                                                    <td class="flex items-center gap-2 p-2 sm:p-3 min-w-[100px]">
                                                        <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                                            <i class="fas fa-calculator text-brand-gold"></i>
                                                        </span>
                                                        Implementing unit
                                                    </td>
                                                    <td class="p-2 sm:p-3 min-w-[80px] border border-brand-gray">${project.implement_unit || ''}</td>
                                                </tr>
                                                <tr class="border-b border-brand-gray">
                                                    <td class="flex items-center gap-2 p-2 sm:p-3 min-w-[100px]">
                                                        <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                                            <i class="fas fa-calendar-alt text-brand-gold"></i>
                                                        </span>
                                                        Implement at
                                                    </td>
                                                    <td class="p-2 sm:p-3 min-w-[80px] border border-brand-gray">${project.implement_at || ''}</td>
                                                    <td class="flex items-center gap-2 p-2 sm:p-3 min-w-[100px]">
                                                        <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                                            <i class="fas fa-bullseye text-brand-gold"></i>
                                                        </span>
                                                        Facade
                                                    </td>
                                                    <td class="p-2 sm:p-3 min-w-[80px] border border-brand-gray">${project.facade.name || ''}</td>
                                                </tr>
                                                <tr>
                                                    <td class="flex items-center gap-2 p-2 sm:p-3 min-w-[100px]">
                                                        <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                                            <i class="fas fa-home text-brand-gold"></i>
                                                        </span>
                                                        Types
                                                    </td>
                                                    <td class="p-2 sm:p-3 min-w-[80px] border border-brand-gray">${project.type.name || ''}</td>
                                                    <td class="flex items-center gap-2 p-2 sm:p-3 min-w-[100px]">
                                                        <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                                            <i class="fas fa-chart-area text-brand-gold"></i>
                                                        </span>
                                                        Size
                                                    </td>
                                                    <td class="p-2 sm:p-3 min-w-[80px] border border-brand-gray">${project.size.name || ''}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </main>
                        </div>
                    `);
                } else {
                    $('#project-detail').html('<p class="text-red-500">Project not found.</p>');
                }
            },
            error: function() {
                $('#project-detail').html('<p class="text-red-500">Error fetching project details.</p>');
            }
        });
    } else {
        $('#project-detail').html('<p class="text-red-500">No project ID provided.</p>');
    }
});
