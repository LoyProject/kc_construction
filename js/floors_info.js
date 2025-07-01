$(document).ready(function() {
    $.ajax({
        url: 'backend/process_fetch_floors.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const $dropdownItemsFloor = $('#dropdown-items-floor');
            if (data.success) {
                $dropdownItemsFloor.empty();
                $.each(data.floors, function(index, floor) {
                    $dropdownItemsFloor.append('<li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, \'floor\')">' + floor.name + '</li>');
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching floors:', textStatus, errorThrown);
        }
    });
});
