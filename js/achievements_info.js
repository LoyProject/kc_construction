$(document).ready(function() {
    $.ajax({
        url: 'backend/process_fetch_achievements.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.success === false) {
                loadingMessage.text(data.message || 'Error fetching data.');
                return;
            }

            // Set the title and subtitle
            $('#achievements-title').text(data.achievement.title || 'Achievements');
            $('#achievements-subtitle').text(data.achievement.subtitle || 'Explore our achievements and milestones.');

            // Set the achievement items
            const achievementItems = $('#achievement-items');
            achievementItems.empty();
            if (Array.isArray(data.achievement_items) && data.achievement_items.length > 0) {
                data.achievement_items.forEach(item => {
                    const itemElement = $(`
                        <div class="achievement-item-${item.id} flex flex-col items-center justify-center text-center mb-8">
                            <div class="flex items-center justify-center mb-4">
                                <div class="bg-brand-black w-16 h-16 rounded-full flex items-center justify-center">
                                    <i class="fas fa-award text-brand-gold text-2xl"></i>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold text-brand-gold">${item.name}</h3>
                            <div class="h-[2px] w-10 bg-gray-200 my-2 mx-auto"></div>
                            <p class="text-brand-white/60">${item.description}</p>
                        </div>
                    `);
                    achievementItems.append(itemElement);
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown);
            loadingMessage.text('Failed to load images. Please check the console.');
        }
    });
});