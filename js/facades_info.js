$(document).ready(function() {
    $.ajax({
        url: 'backend/process_fetch_facades.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const $dropdownItemsFacade = $('#dropdown-items-facade');
            if (data.success) {
                $dropdownItemsFacade.empty();
                $.each(data.facades, function(index, facade) {
                    $dropdownItemsFacade.append('<li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, \'facade\')">' + facade.name + '</li>');
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching facades:', textStatus, errorThrown);
        }
    });
});
