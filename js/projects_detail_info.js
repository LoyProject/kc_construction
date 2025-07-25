async function loadData() {
    try {
        const fetchFloors = new Promise((resolve, reject) => {
            $.ajax({
                url: 'backend/process_fetch_floors.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const $floorsList = $('#floors-list');
                    if (data.success) {
                        $floorsList.empty();
                        $.each(data.floors, function(index, floor) {
                            $floorsList.append(`
                                <button class="floor-item bg-brand-gray px-3 py-2 hover:bg-brand-gold hover:text-white text-xs sm:text-sm" 
                                    data-id="${floor.id}" data-type="${floor.name}">${floor.name}
                                </button>
                            `);
                        }); 
                        resolve();
                    } else {
                        reject(new Error('Floors data fetch unsuccessful'));
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    reject(new Error(`Error fetching floors: ${textStatus} ${errorThrown}`));
                }
            });
        });

        // const fetchFacades = new Promise((resolve, reject) => {
        //     $.ajax({
        //         url: 'backend/process_fetch_facades.php',
        //         method: 'GET',
        //         dataType: 'json',
        //         success: function(data) {
        //             const $facadeList = $('#facade-list');
        //             if (data.success) {
        //                 $facadeList.empty();
        //                 $.each(data.facades, function(index, facade) {
        //                     $facadeList.append(`
        //                         <button class="facade-item bg-brand-gray px-3 py-2 hover:bg-brand-gold hover:text-white text-xs sm:text-sm" 
        //                             data-id="${facade.id}" data-type="${facade.name}">${facade.name}
        //                         </button>
        //                     `);
        //                 });
        //                 resolve();
        //             } else {
        //                 reject(new Error('Facades data fetch unsuccessful'));
        //             }
        //         },
        //         error: function(jqXHR, textStatus, errorThrown) {
        //             reject(new Error(`Error fetching facades: ${textStatus} ${errorThrown}`));
        //         }
        //     });
        // });

        await Promise.all([fetchFloors]);
    } catch (error) {
        console.error('Error in loadData:', error.message);
    }
}

$(document).ready(function() {
    const projectId = new URLSearchParams(window.location.search).get('id');

    $('#dropdownInput-style').attr('data-id', '').val('');
    $('#dropdownInput-type').attr('data-id', '').val('');
    $('#dropdownInput-floor').attr('data-id', '').val('');
    // $('#dropdownInput-area').attr('data-id', '').val('');
    // $('#dropdownInput-facade').attr('data-id', '').val('');

    if (projectId) {
        $.ajax({
            url: 'backend/process_fetch_projects_detail.php',
            type: 'POST',
            data: { id: projectId },
            dataType: 'json',
            success: async function(data) {
                if (data.success) {
                    const project = data.project;
                    let detailFloorHtml = '';
                    let detailAreaHtml = '';
                    let vedioHtml = '';

                    if (project.detail_floor) {
                        detailFloorHtml = `
                            <div class="mt-6 sm:mt-8 md:mt-10">
                                <h3 class="text-lg font-semibold my-4" data-translate="details-about-floors"></h3>
                                <span class="text-sm text-brand-white">${project.detail_floor}</span>
                            </div>
                        `;
                    }

                    if (project.detail_area) {
                        detailAreaHtml = `
                            <div class="mt-6 sm:mt-8 md:mt-10">
                                <h3 class="text-lg font-semibold my-4" data-translate="Details-of-area"></h3>
                                <span class="text-sm text-brand-white">${project.detail_area}</span>
                            </div>
                        `;
                    }

                    if (project.video) {
                        let youtubeId = '';
                        const url = project.video;
                        const match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i);
                        if (match && match[1]) youtubeId = match[1];
                        if (youtubeId) {
                            vedioHtml = `
                                <div class="mt-6 sm:mt-8 md:mt-10">
                                    <h3 class="text-lg font-semibold my-4" data-translate="video-of-project"></h3>
                                    <div class="w-full max-w-2xl aspect-video bg-brand-gray shadow rounded overflow-hidden">
                                        <iframe 
                                            src="https://www.youtube.com/embed/${youtubeId}" frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen
                                            class="w-full h-full"
                                        ></iframe>
                                    </div>
                                </div>
                            `;
                        }
                    }

                    // Merge main image and images array into one list
                    let allImages = [];
                    if (project.image_path) {
                        allImages.push({ image_path: project.image_path });
                    }
                    if (Array.isArray(project.images)) {
                        allImages = allImages.concat(project.images);
                    } else if (typeof project.images === 'string' && project.images.trim() !== '') {
                        try {
                            const parsed = JSON.parse(project.images);
                            if (Array.isArray(parsed)) {
                                allImages = allImages.concat(parsed);
                            }
                        } catch (e) {
                            // ignore parse error
                        }
                    }

                    // Render main image viewer with arrows and thumbnails
                    $('#project-detail').html(`
                        <div class="bg-brand-black text-white">
                            <main>
                                <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">
                                    <div class="w-full">
                                        <div class="relative">
                                            <button id="img-prev-btn" class="absolute left-2 top-1/2 -translate-y-1/2 z-10 bg-black/50 hover:bg-black/80 text-white rounded-full w-8 h-8 flex items-center justify-center" style="display:${allImages.length > 1 ? 'block' : 'none'}">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <div class="w-full aspect-[4/3] overflow-hidden shadow-sm">
                                                <img id="main-project-img" src="admin/${allImages[0]?.image_path || ''}" class="shadow mb-4 w-full h-full object-cover cursor-pointer" />
                                            </div>
                                            <button id="img-next-btn" class="absolute right-2 top-1/2 -translate-y-1/2 z-10 bg-black/50 hover:bg-black/80 text-white rounded-full w-8 h-8 flex items-center justify-center" style="display:${allImages.length > 1 ? 'block' : 'none'}">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                        <div class="flex gap-2 overflow-x-auto pb-2 mt-2">
                                            ${
                                                allImages.map((item, i) => `
                                                    <img src="admin/${item.image_path}" alt="Thumb ${i+1}"
                                                        class="project-thumb w-20 h-14 sm:w-24 sm:h-16 md:w-28 md:h-20 fit-cover shadow cursor-pointer border-2 ${i === 0 ? 'border-brand-gold' : 'border-transparent'}"
                                                        data-index="${i}"
                                                    />
                                                `).join('')
                                            }
                                        </div>
                                    </div>

                                    <!-- Right: Filter Buttons -->
                                    <div class="w-full lg:w-1/3 space-y-6">
                                        <div>
                                            <h2 class="text-base sm:text-lg font-semibold mb-2 border-b pb-1 border-yellow-500 inline-block" data-translate="floor-number">FLOOR NUMBER</h2>
                                            <div id="floors-list" class="grid grid-cols-2 sm:grid-cols-3 gap-2"></div>
                                        </div>

                                        <!-- <div>
                                            <h2 class="text-base sm:text-lg font-semibold mb-2 border-b pb-1 border-yellow-500 inline-block" data-translate="facade">FACADE</h2>
                                            <div id="facade-list" class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                                <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">7m - 8m</button>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>

                                <!-- Title -->
                                <div class="mt-6 sm:mt-8 md:mt-10">
                                    <h1 class="text-lg sm:text-xl md:text-2xl font-semibold text-brand-gold">${project.name}</h1>
                                </div>

                                <!-- Info Table -->
                                <div class="mt-4 sm:mt-6">
                                    <h2 class="text-base sm:text-lg font-bold border-b border-brand-gold inline-block mb-3 sm:mb-4" data-translate="general-info">GENERAL INFOMATIONS</h2>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 border border-brand-gray text-xs sm:text-sm">
                                        <!-- View -->
                                        <div class="flex items-center gap-2 p-2 border border-brand-gray">
                                        <i class="fas fa-eye text-brand-gold w-4"></i>
                                        <span data-translate="view-detail"></span>
                                        </div>
                                        <div class="p-2 border border-brand-gray">${project.view || 0}</div>

                                        <!-- Investor -->
                                        <div class="flex items-center gap-2 p-2 border border-brand-gray">
                                        <i class="fas fa-user text-brand-gold w-4"></i>
                                        <span data-translate="investor-detail"></span>
                                        </div>
                                        <div class="p-2 border border-brand-gray">${project.investor || '--'}</div>

                                        <!-- Style -->
                                        <div class="flex items-center gap-2 p-2 border border-brand-gray">
                                        <i class="fas fa-bullseye text-brand-gold w-4"></i>
                                        <span data-translate="style"></span>
                                        </div>
                                        <div class="p-2 border border-brand-gray">${project.style.name || '--'}</div>
                                            
                                        <!-- Total Area -->
                                        <div class="flex items-center gap-2 p-2 border border-brand-gray">
                                        <i class="fas fa-cogs text-brand-gold w-4"></i>
                                        <span data-translate="total-area"></span>
                                        </div>
                                        <div class="p-2 border border-brand-gray">${project.area || '--'}</div>

                                        <!-- Floor Number -->
                                        <div class="flex items-center gap-2 p-2 border border-brand-gray">
                                        <i class="fas fa-chart-bar text-brand-gold w-4"></i>
                                        <span data-translate="floor-number"></span>
                                        </div>
                                        <div class="p-2 border border-brand-gray">${project.floor.name || '--'}</div>

                                        <!-- Implementing Unit -->
                                        <div class="flex items-center gap-2 p-2 border border-brand-gray">
                                        <i class="fas fa-calculator text-brand-gold w-4"></i>
                                        <span data-translate="implementing-unit"></span>
                                        </div>
                                        <div class="p-2 border border-brand-gray">${project.implement_unit || '--'}</div>

                                        <!-- Implement At -->
                                        <div class="flex items-center gap-2 p-2 border border-brand-gray">
                                        <i class="fas fa-calendar-alt text-brand-gold w-4"></i>
                                        <span data-translate="implement-at"></span>
                                        </div>
                                        <div class="p-2 border border-brand-gray">${project.implement_at || '--'}</div>

                                        <!-- Facade -->
                                        <div class="flex items-center gap-2 p-2 border border-brand-gray">
                                        <i class="fas fa-bullseye text-brand-gold w-4"></i>
                                        <span data-translate="facade"></span>
                                        </div>
                                        <div class="p-2 border border-brand-gray">${project.facade || '--'}</div>

                                        <!-- Type -->
                                        <div class="flex items-center gap-2 p-2 border border-brand-gray">
                                        <i class="fas fa-home text-brand-gold w-4"></i>
                                        <span data-translate="types"></span>
                                        </div>
                                        <div class="p-2 border border-brand-gray">${project.type.name || '--'}</div>

                                        <!-- Size -->
                                        <div class="flex items-center gap-2 p-2 border border-brand-gray">
                                        <i class="fas fa-chart-area text-brand-gold w-4"></i>
                                        <span data-translate="size"></span>
                                        </div>
                                        <div class="p-2 border border-brand-gray">${project.size || '--'}</div>
                                    </div>
                                </div>

                                ${detailFloorHtml}
                                ${detailAreaHtml}
                                ${vedioHtml}
                            </main>
                        </div>
                        
                        <!-- Popup Dialog -->
                        <div id="img-popup-dialog" style="display:none; position:fixed; top:0; left:0; width:95vw; height:100vh; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
                            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); max-width:90vw; max-height:90vh;">
                                <button id="img-popup-close" style="position:absolute; top:10px; right:10px; background:#222; color:#fff; border:none; border-radius:50%; width:32px; height:32px; font-size:20px; cursor:pointer; z-index:2;">&times;</button>
                                <a id="img-popup-download" href="#" download style="position:absolute; top:10px; left:10px; background:#222; color:#fff; border:none; border-radius:50%; width:32px; height:32px; font-size:18px; cursor:pointer; z-index:2; display:flex; align-items:center; justify-content:center;" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                                <img id="img-popup-img" src="" style="max-width:90vw; max-height:80vh; display:block; margin:auto; border-radius:8px; box-shadow:0 2px 16px #000;" />
                            </div>
                        </div>
                    `);

                    // Popup dialog logic
                    $('#main-project-img, .project-thumb').off('click.imgpopup').on('click.imgpopup', function() {
                        let src = $(this).attr('src');
                        $('#img-popup-img').attr('src', src);
                        $('#img-popup-download').attr('href', src);
                        $('#img-popup-dialog').fadeIn(150);
                    });
                    $('#img-popup-close, #img-popup-dialog').off('click.imgpopup').on('click.imgpopup', function(e) {
                        if (e.target === this) $('#img-popup-dialog').fadeOut(150);
                    });

                    // Add image viewer logic
                    (function() {
                        let currentIndex = 0;
                        const total = allImages.length;

                        function showImage(idx) {
                            if (idx < 0 || idx >= total) return;
                            $('#main-project-img').attr('src', 'admin/' + allImages[idx].image_path);
                            $('.project-thumb').removeClass('border-brand-gold').addClass('border-transparent');
                            $('.project-thumb[data-index="' + idx + '"]').removeClass('border-transparent').addClass('border-brand-gold');
                            currentIndex = idx;
                        }

                        $('#img-prev-btn').off('click').on('click', function() {
                            let idx = (currentIndex - 1 + total) % total;
                            showImage(idx);
                        });

                        $('#img-next-btn').off('click').on('click', function() {
                            let idx = (currentIndex + 1) % total;
                            showImage(idx);
                        });

                        $('.project-thumb').off('click').on('click', function() {
                            let idx = parseInt($(this).attr('data-index'), 10);
                            showImage(idx);
                        });
                    })();

                    await loadData();
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
