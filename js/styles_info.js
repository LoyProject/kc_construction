$(document).ready(function() {
    $.ajax({
        url: 'backend/process_fetch_styles.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const $dropdownItemsStyle = $('#dropdown-items-style');
            if (data.success) {
                $dropdownItemsStyle.empty();
                $.each(data.styles, function(index, style) {
                    $dropdownItemsStyle.append('<li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, \'style\')">' + style.name + '</li>');
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching styles:', textStatus, errorThrown);
        }
    });
});
