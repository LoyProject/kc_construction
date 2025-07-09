<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="page-title"></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/color_config.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-brand-black text-brand-white">
    <header x-data="{ open: false}"
        class="w-full px-4 sm:px-20 py-4 flex items-center justify-between bg-brand-gray text-brand-gold shadow-sm mx-auto sticky top-0 z-50 shadow-lg">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <a href="home"><img id="company-logo-header" class="h-10 sm:h-12"></a>
        </div>

        <!-- Hamburger for mobile -->
        <div class="md:hidden flex items-center">
            <button @click="open = !open" :aria-expanded="open.toString()" aria-label="Toggle navigation">
                <svg :class="{'hidden': open, 'block': !open}" class="w-7 h-7" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg :class="{'block': open, 'hidden': !open}" class="w-7 h-7" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Desktop Nav & Right Side -->
        <div class="hidden md:flex items-center justify-end flex-1 ml-8">
            <nav class="flex space-x-6 lg:space-x-8 uppercase font-semibold text-sm">
                <a href="home" class="hover:text-brand-white" data-translate="home">Home</a>
                <a href="about" class="hover:text-brand-white" data-translate="about">About Us</a>
                <a href="projects" class="hover:text-brand-white" data-translate="projects">Projects</a>
                <a href="contact" class="hover:text-brand-white" data-translate="contact">Contact</a>
            </nav>
            <div class="flex items-center space-x-3 lg:space-x-4 ml-8">
                <a href="quote_request">
                    <button
                        class="border border-brand-gold px-3 py-2 lg:px-4 uppercase font-semibold text-sm hover:bg-brand-gold hover:text-white transition-colors"
                        data-translate="quote-request">
                        Quote Request
                    </button>
                </a>
                <div x-data="{ showSearch: false }" class="relative">
                    <button @click="showSearch = !showSearch" class="focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1011 18.5a7.5 7.5 0 005.65-2.85z">
                            </path>
                        </svg>
                    </button>
                    <div x-show="showSearch" @click.away="showSearch = false" x-cloak
                        class="absolute right-0 mt-2 w-64 p-2 z-50">
                        <form id="header-search-form" autocomplete="off">
                            <input type="text" id="header-search-input" placeholder="Search..." <?php echo htmlspecialchars($translations['search'] ?? 'Search'); ?> data-translate="search"
                                class="w-full px-3 py-2 border border-brand-gray focus:outline-none focus:ring-2 focus:ring-brand-gold text-sm text-black">
                        </form>
                        <div id="header-search-results"
                            class="bg-white text-black mt-2 rounded shadow max-h-60 overflow-y-auto hidden"></div>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(function () {
                        $('#header-search-input').on('input', function () {
                            var keyword = $(this).val().trim();
                            if (keyword.length < 2) {
                                $('#header-search-results').hide().empty();
                                return;
                            }
                            $.ajax({
                                url: 'search.php',
                                method: 'GET',
                                data: { q: keyword },
                                dataType: 'json',
                                success: function (data) {
                                    var $results = $('#header-search-results');
                                    $results.empty();
                                    if (data.length === 0) {
                                        $results.append('<div class="p-2 text-gray-500">No results found.</div>');
                                    } else {
                                        data.forEach(function (item) {
                                            $results.append(
                                                '<a href="' + item.url + '" class="block px-3 py-2 hover:bg-brand-gray">' +
                                                $('<div>').text(item.title).html() +
                                                '</a>'
                                            );
                                        });
                                    }
                                    $results.show();
                                },
                                error: function () {
                                    $('#header-search-results').hide().empty();
                                }
                            });
                        });
                        // Hide results when clicking outside
                        $(document).on('click', function (e) {
                            if (!$(e.target).closest('#header-search-form, #header-search-results').length) {
                                $('#header-search-results').hide().empty();
                            }
                        });
                    });
                </script>
                <div class="flex items-center space-x-1 ml-2">
                    <button id="langToggleBtn" class="focus:outline-none" aria-label="Switch to Khmer">
                        <img id="langFlag" src="https://flagcdn.com/24x18/kh.png" alt="English"
                            class="w-6 h-4 rounded shadow">
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Nav -->
        <div x-cloak x-show="open" class="fixed inset-0 z-40 bg-black/40 flex md:hidden" @click.away="open = false">
            <div class="bg-brand-black text-brand-gold w-3/4 max-w-xs h-full p-6 flex flex-col">
                <div class="flex items-center space-x-2 mb-8">
                    <a href="home"><img id="company-logo-header" class="h-18 sm:h-24"></a>
                </div>
                <div class="flex items-center">
                    <input type="text" placeholder="Search..." data-translate="search"
                        class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-gray text-sm">
                    <button class="ml-2 p-2 text-brand-white hover:bg-brand-gold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1011 18.5a7.5 7.5 0 005.65-2.85z">
                            </path>
                        </svg>
                    </button>
                </div>
                <ul class="space-y-2 text-sm mt-4">
                    <li class="flex items-center bg-brand-gray p-2 mb-2 hover:bg-brand-gold hover:text-white">
                        <span class="flex items-center justify-center w-4 h-4 p-1 mr-2">
                            <i class="fas fa-home"></i>
                        </span>
                        <a href="index" data-translate="home">Home</a>
                    </li>
                    <li class="flex items-center bg-brand-gray p-2 mb-2 hover:bg-brand-gold hover:text-white">
                        <span class="flex items-center justify-center w-4 h-4 p-1 mr-2">
                            <i class="fas fa-info-circle"></i>
                        </span>
                        <a href="about" data-translate="about">About Us</a>
                    </li>
                    <li class="flex items-center bg-brand-gray p-2 mb-2 hover:bg-brand-gold hover:text-white">
                        <span class="flex items-center justify-center w-4 h-4 p-1 mr-2">
                            <i class="fas fa-project-diagram"></i>
                        </span>
                        <a href="projects" data-translate="projects">Projects</a>
                    </li>
                    <li class="flex items-center bg-brand-gray p-2 mb-2 hover:bg-brand-gold hover:text-white">
                        <span class="flex items-center justify-center w-4 h-4 p-1 mr-2">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <a href="contact" data-translate="contact">Contact</a>
                    </li>
                </ul>
                <a href="quote_request" class="flex justify-center mt-8">
                    <button
                        class="border border-brand-gold px-3 py-2 lg:px-4 uppercase font-semibold text-sm hover:bg-brand-gold hover:text-white transition-colors" data-translate="quote-request">
                        Quote Request
                    </button>
                </a>
            </div>
            <div class="flex-1" @click="open = false"></div>
        </div>
    </header>