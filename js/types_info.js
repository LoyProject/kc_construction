$(document).ready(function() {
    $.ajax({
        url: 'backend/process_fetch_types.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const $typesList = $('#types-list');
            const $dropdownItemsType = $('#dropdown-items-type');
            if (data.success) {
                $typesList.empty();
                $dropdownItemsType.empty();
                $.each(data.types, function(index, type) {
                    if (index === 0) {
                        $typesList.append('<div class="type-item text-brand-white hover:text-brand-gold cursor-pointer text-sm sm:text-base lg:text-lg font-semibold text-brand-white" data-type="all">All</div><span class="mx-6">|</span>');
                    }
                    $typesList.append('<div class="type-item text-brand-white hover:text-brand-gold cursor-pointer text-sm sm:text-base lg:text-lg font-semibold text-brand-white" data-type="' + type.name + '">' + type.name + '</div>' + (index < data.types.length - 1 ? '<span class="mx-6">|</span>' : ''));
                });
                $.each(data.types, function(index, type) {
                    $dropdownItemsType.append(`
                        <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'type')" data-id="${type.id}">${type.name}</li>
                    `);
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching types:', textStatus, errorThrown);
        }
    });
});
