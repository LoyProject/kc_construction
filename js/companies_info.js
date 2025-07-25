$(document).ready(function () {
    $.ajax({
        url: 'backend/process_fetch_companies.php',
        method: 'GET',
        dataType: 'json',
        beforeSend: function() {
            $('html, body').stop().animate({ scrollTop: 0 }, 300);
            $('#loading-overlay-about').removeClass('hidden');
        },
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
            var $youtubeLink = $('#youtube-link');
            var $tiktokLink = $('#tiktok-link');
            var $telegramlinkButton = $('#telegram-link-button');
            var $companyName = $('#company-name');
            var $companyProfileImage = $('#company-profile-image');
            var $companyProfile = $('#company-profile');
            var $companyVisionImage = $('#company-vision-image');
            var $companyVision = $('#company-vision');

            if (data.success) {
                var page = window.location.pathname.split('/').pop();
                if (page === 'index' || page === '' || page === 'index') {
                    $pageTitle.text(data.company.name);
                } else if (page === 'about') {
                    $pageTitle.text('About - ' + data.company.name);
                } else if (page === 'contact') {
                    $pageTitle.text('Contact - ' + data.company.name);
                } else if (page === 'projects') {
                    $pageTitle.text('Projects - ' + data.company.name);
                } else if (page === 'projects_detail') {
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
                $youtubeLink.attr('href', data.company.youtube).text('YouTube');
                $tiktokLink.attr('href', data.company.tiktok).text('TikTok');
                $telegramlinkButton.attr('href', data.company.telegram).html('<i class="fab fa-telegram-plane mr-2"></i> Telegram Chat');
                $companyName.text(data.company.name).html('&copy; ' + data.company.name + ' POWER by <span class="text-brand-gold font-medium">Loy Team</span>');
                $companyProfileImage.attr('src', data.company.mission_image);
                $companyProfileImage.attr('alt', data.company.name);
                $companyProfile.html(data.company.description);
                $companyVisionImage.attr('src', data.company.vision_image);
                $companyVisionImage.attr('alt', data.company.name);
                $companyVision.html(data.company.vision);
            } else {
                $companyLogo.attr('src', 'admin/assets/companies/default_logo.png');
                $companyLogo.attr('alt', 'K.C Construction & Design');
                console.error('Failed to fetch companies:', data.message);
            }

            $('#loading-overlay-about').addClass('hidden');
            setTimeout(() => { $('html, body').stop().animate({ scrollTop: 0 }, 300); }, 50);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching companies:', textStatus, errorThrown);
        }
    });
});