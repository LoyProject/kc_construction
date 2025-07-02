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
                    $dropdownItemsFacade.append(`
                        <li class="px-3 py-2 hover:bg-gray-700 cursor-pointer" onclick="selectItem(this, 'facade')" data-id="${facade.id}">${facade.name}</li>
                    `);
                });

                const facadeId = sessionStorage.getItem('selectedFacadeId');
                const facadeLabel = sessionStorage.getItem('selectedFacadeLabel');

                if (facadeId && facadeLabel) {
                    const $facadeInput = $('#dropdownInput-facade');

                    if ($facadeInput.length) {
                        $facadeInput.val(facadeLabel);
                        $facadeInput.attr('data-id', facadeId);
                    }

                    sessionStorage.removeItem('selectedFacadeId');
                    sessionStorage.removeItem('selectedFacadeLabel');

                    setTimeout(() => loadProjects(1), 100);
                } else {
                    loadProjects(1);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching facades:', textStatus, errorThrown);
        }
    });
});
