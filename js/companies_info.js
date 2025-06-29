$(document).ready(function () {
    $.ajax({
        url: 'backend/process_fetch_companies.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            var $pageTitle = $('#page-title');
            var $companyLogo = $('#company-logo-header, #company-logo-footer');
            var $companyAddress = $('#company-address');
            var $companyPhone = $('#company-phone');
            var $companySchedule = $('#company-schedule');
            var $facebookLink = $('#facebook-link');
            var $telegramLink = $('#telegram-link');

            if (data.success) {
                var page = window.location.pathname.split('/').pop();
                if (page === 'index' || page === '' || page === 'index') {
                    $pageTitle.text(data.company.name);
                } else if (page === 'about_page') {
                    $pageTitle.text('About - ' + data.company.name);
                } else if (page === 'contact_page') {
                    $pageTitle.text('Contact - ' + data.company.name);
                } else if (page === 'project_page') {
                    $pageTitle.text('Projects - ' + data.company.name);
                } else if (page === 'project_detail_page') {
                    $pageTitle.text('Project Details - ' + data.company.name);
                } else {
                    $pageTitle.text(data.company.name);
                }
                $companyLogo.attr('src', data.company.logo);
                $companyLogo.attr('alt', data.company.name);
                $companyAddress.text(data.company.address);
                $companyPhone.text(data.company.tel);
                $companySchedule.text(data.company.schedule);
                $facebookLink.attr('href', data.company.facebook).text('Facebook');
                $telegramLink.attr('href', data.company.telegram).text('Telegram');
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