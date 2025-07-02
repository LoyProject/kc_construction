$(document).ready(function() {
    $.ajax({
        url: 'backend/process_fetch_areas.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const $dropdownItemsArea = $('#dropdown-items-area');
            if (data.success) {
                $dropdownItemsArea.empty();
                $.each(data.areas, function(index, area) {
                    $dropdownItemsArea.append(`
                        <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'area')" data-id="${area.id}">${area.name}</li>
                    `);
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching areas:', textStatus, errorThrown);
        }
    });
});
