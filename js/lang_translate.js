
const translations = {
    en: {
        "title": "Welcome",
        "desc": "This is an example in English.",
        "header-home": "Home",
        "header-about": "About Us",
        "header-projects": "Projects",
        "header-contact": "Contact",
        "header-quote-request": "Quote Request",
        "header-quick-link": "Quick Link",
        "header-follow-us": "Follow Us",
        "projects-view": "View:",
        "projects-investor": "Investor:",
        "projects-address": "Address:",
        "projects-area": "Area:",
        "projects-floor": "Number of floors:"
    },
    kh: {
        "title": "សូមស្វាគមន៍",
        "desc": "នេះគឺជាគំរូជាភាសាខ្មែរ។",
        "header-home": "ទំព័រដើម",
        "header-about": "អំពី​ពួក​យើង",
        "header-projects": "គម្រោង",
        "header-contact": "ទំនាក់ទំនង",
        "header-quote-request": "សំណើសម្រង់",
        "header-quick-link": "តំណភ្ជាប់ឆាប់",
        "header-follow-us": "តាមដាន​ពួក​យើង",
        "projects-view": "មើល:",
        "projects-investor": "អ្នកវិនិយោគ:",
        "projects-address": "អាសយដ្ឋាន:",
        "projects-area": "ផ្ទៃប្រហែល:",
        "projects-floor": "ចំនួនជាន់:"
    }
};

function applyLang(lang) {
    $('#langFlag').attr('src', lang === 'en'
        ? 'https://flagcdn.com/24x18/kh.png'
        : 'https://flagcdn.com/24x18/gb.png');

    $('#langFlag').attr('alt', lang === 'en' ? 'English' : 'Khmer');
    $('#langToggleBtn').attr('aria-label', lang === 'en' ? 'Switch to Khmer' : 'Switch to English');

    $("[data-translate]").each(function () {
        const key = $(this).data("translate");
        if (translations[lang] && translations[lang][key]) {
            $(this).text(translations[lang][key]);
        }
    });
}

$(document).ready(function () {
    let lang = localStorage.getItem('lang') || 'en';
    applyLang(lang);

    $('#langToggleBtn').on('click', function () {
        lang = lang === 'en' ? 'kh' : 'en';
        localStorage.setItem('lang', lang);
        applyLang(lang);
    });
});
