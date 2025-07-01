$(document).ready(function () {
    $.ajax({
        url: 'backend/process_fetch_companies.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            var $pageTitle = $('#page-title');
            var $companyLogo = $('#company-logo-header, #company-logo-footer');
            var $companyAddress = $('#company-address, #contact-address');
            var $companyMap = $('#company-map, #contact-map');
            var $companyPhone = $('#company-phone, #contact-phone');
            var $companySchedule = $('#company-schedule');
            var $contactEmail = $('#contact-email');
            var $facebookLink = $('#facebook-link');
            var $telegramLink = $('#telegram-link');
            var $instagramLink = $('#instagram-link');
            var $youtubeLink = $('#youtube-link');
            var $linkedInLink = $('#linkedin-link');
            var $telegramlinkButton = $('#telegram-link-button');
            var $companyName = $('#company-name');
            var $companyProfile = $('#company-profile');
            var $companyVision = $('#company-vision');

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
                $companyMap.attr('href', data.company.map);
                $companyPhone.text(data.company.tel);
                $companySchedule.text(data.company.schedule);
                $contactEmail.text(data.company.email);
                $facebookLink.attr('href', data.company.facebook).text('Facebook');
                $telegramLink.attr('href', data.company.telegram).text('Telegram');
                $instagramLink.attr('href', data.company.instagram).text('Instagram');
                $youtubeLink.attr('href', data.company.youtube).text('YouTube');
                $linkedInLink.attr('href', data.company.linkedin).text('LinkedIn');
                $telegramlinkButton.attr('href', data.company.telegram).html('<i class="fab fa-telegram-plane mr-2"></i> Telegram Chat');
                $companyName.text(data.company.name).html('&copy; ' + data.company.name + ' POWER by <span class="text-brand-gold font-medium">Loy Team</span>');
                $companyProfile.html(data.company.description);
                $companyVision.html(data.company.vision);
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