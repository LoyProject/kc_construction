
const translations = {
    en: {
        "home": "Home",
        "about": "About Us",
        "projects": "Projects",
        "contact": "Contact",
        "quote-request": "Quote Request",
        "quick-link": "Quick Link",
        "follow-us": "Follow Us",
        "view": "View:",
        "investor": "Investor:",
        "address": "Address:",
        "area": "Area:",
        "area-dropdown": "Floor Area",
        "floor": "Number of floors:",
        "floor-dropdown": "Number of floor",
        "all-projects": "All Projects",
        "style": "Style",
        "type": "Type",
        "facade": "Facade",
        "who-we-are": "Who we are?",
        "our-companies": "OUR COMPANIES",
        "vision": "Design Vision",
        "contact-discription": "Are you interested in finding out how our Construction Services can make your project? For more information on our services please contact us.",
        "information": "INFORMATION",
        "head-office": "HEAD OFFICE",
        "send-us": "SEND US",
        "sumbit-qoute": "SUBMIT A CONSULTATION REQUEST",
        "load-more": "Load More",
        "load-all": "All",
        "search": "Search",
        "floor-number": "FLOOR NUMBER",
        "general-info": "GENERAL INFOMATIONS",
        "name": "Name*",
        "phone": "Phone*",
        "email": "Email*",
        "subject": "Subject*",
        "message": "Message*",
        "contact-phone": "CALL US :",
        "contact-email": "EMAIL :",
        "contact-address": "ADDRESS :",
    },
    kh: {
        "home": "ទំព័រដើម",
        "about": "អំពី​ពួក​យើង",
        "projects": "គម្រោង",
        "contact": "ទំនាក់ទំនង",
        "quote-request": "សំណើសម្រង់",
        "quick-link": "តំណភ្ជាប់ឆាប់",
        "follow-us": "តាមដាន​ពួក​យើង",
        "view": "មើល:",
        "investor": "អ្នកវិនិយោគ:",
        "address": "អាសយដ្ឋាន:",
        "area": "ផ្ទៃក្រឡា:",
        "area-dropdown": "ផ្ទៃក្រឡា",
        "floor": "ចំនួនជាន់:",
        "floor-dropdown": "ចំនួនជាន់",
        "all-projects": "គម្រោងទាំងអស់",
        "style": "រចនាបថ",
        "type": "ប្រភេទ",
        "facade": "មុខមាត់",
        "who-we-are": "យើងជាអ្នកណា?",
        "our-companies": "ក្រុមហ៊ុនរបស់យើង",
        "vision": "ទស្សនៈ",
        "contact-discription": "តើអ្នកមានចំណាប់អារម្មណ៍ក្នុងការស្វែងយល់ពីរបៀបដែលសេវាកម្មសំណង់របស់យើងអាចធ្វើឲ្យគម្រោងរបស់អ្នកកាន់តែប្រសើរឡើងទេ? សម្រាប់ព័ត៌មានលម្អិតអំពីសេវាកម្មរបស់យើង សូមទំនាក់ទំនងមកយើង។",
        "information": "ព័ត៌មាន",
        "head-office": "ការិយាល័យកណ្តាល",
        "send-us": "បញ្ជូន",
        "sumbit-qoute": "ដាក់សំណើសុំប្រឹក្សា",
        "load-more": "បង្ហាញបន្ថែម",
        "load-all": "ទាំងអស់",
        "search": "ស្វែងរក",
        "floor-number": "ចំនួនជាន់",
        "general-info": "ព័ត៌មានទូទៅ",
        "name": "ឈ្មោះ*",
        "phone": "លេខទូរស័ព្ទ*",
        "email": "អ៊ីមែល*",
        "subject": "ប្រធានបទ*",
        "message": "សារ*",
        "contact-phone": "ទំនាក់ទំនង :",
        "contact-email": "អ៊ីមែល :",
        "contact-address": "អាសយដ្ឋាន :",
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
            const translation = translations[lang][key];

            if ($(this).is('[placeholder]')) {
                $(this).attr("placeholder", translation);
            } else {
                $(this).text(translation);
            }
        }
    });
}

$(document).ready(function () {
    let lang = localStorage.getItem('lang') || 'kh';
    applyLang(lang);

    $('#langToggleBtn').on('click', function () {
        lang = lang === 'en' ? 'kh' : 'en';
        localStorage.setItem('lang', lang);
        applyLang(lang);
    });
});
