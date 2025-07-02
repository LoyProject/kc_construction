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
                    $dropdownItemsFloor.append(`
                        <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'floor')" data-id="${floor.id}">${floor.name}</li>
                    `);
                });

                const floorId = sessionStorage.getItem('selectedFloorId');
                const floorLabel = sessionStorage.getItem('selectedFloorLabel');

                if (floorId && floorLabel) {
                    const $floorInput = $('#dropdownInput-floor');

                    if ($floorInput.length) {
                        $floorInput.val(floorLabel);
                        $floorInput.attr('data-id', floorId);
                    }

                    sessionStorage.removeItem('selectedFloorId');
                    sessionStorage.removeItem('selectedFloorLabel');

                    setTimeout(() => loadProjects(1), 100);
                } else {
                    loadProjects(1);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching floors:', textStatus, errorThrown);
        }
    });
});
