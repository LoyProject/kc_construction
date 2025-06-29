$(document).ready(function () {
    $.ajax({
        url: 'backend/process_fetch_companies.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            var $companyLogo = $('#company-logo');
            if (data.success) {
                $companyLogo.attr('src', data.company.logo);
                $companyLogo.attr('alt', data.company.name);
            } else {
                $companyLogo.attr('src', 'admin/assets/companies/default_logo.png');
                $companyLogo.attr('alt', 'K.C Construction & Design');
                console.error('Failed to fetch companies:', data.message);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching companies:', textStatus, errorThrown);
        }
    });
});