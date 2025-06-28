<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>

<body">
    <header x-data="{ open: false }"
        class="w-full px-4 sm:px-20 py-4 flex items-center justify-between bg-brand-gray text-brand-gold shadow-sm mx-auto">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="images/logo.png" alt="Men Luxury Logo" class="h-10 sm:h-12">
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
                <a href="index.php" class="hover:text-brand-white">Home</a>
                <a href="about_page.php" class="hover:text-brand-white">About Us</a>
                <a href="project_page.php" class="hover:text-brand-white">Projects</a>
                <a href="contact_page.php" class="hover:text-brand-white">Contact</a>
            </nav>
            <div class="flex items-center space-x-3 lg:space-x-4 ml-8">
                <a href="quote_request_page.php">
                    <button
                        class="border border-brand-gold px-3 py-2 lg:px-4 uppercase font-semibold text-sm hover:bg-brand-gold hover:text-white transition-colors">
                        Quote Request
                    </button>
                </a>
                <button>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1011 18.5a7.5 7.5 0 005.65-2.85z">
                        </path>
                    </svg>
                </button>
                <!-- Language Switcher -->
                <div x-data="{ lang: 'kh' }" class="flex items-center space-x-1 ml-2">
                    <button @click="lang = lang === 'en' ? 'kh' : 'en'"
                        :aria-label="lang === 'en' ? 'Switch to Khmer' : 'Switch to English'"
                        class="focus:outline-none">
                        <img :src="lang === 'en' ? 'https://flagcdn.com/24x18/gb.png' : 'https://flagcdn.com/24x18/kh.png'"
                            :alt="lang === 'en' ? 'English' : 'Khmer'" class="w-6 h-4 rounded shadow">
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Nav -->
        <div x-cloak x-show="open" class="fixed inset-0 z-40 bg-black/40 flex md:hidden" @click.away="open = false">
            <div class="bg-white w-3/4 max-w-xs h-full p-6 flex flex-col space-y-6">
                <div class="mt-2 flex items-center">
                    <input type="text" placeholder="Search..."
                        class="w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                    <button class="ml-2 p-2 bg-brand-gold text-white hover:bg-brand-gold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1011 18.5a7.5 7.5 0 005.65-2.85z">
                            </path>
                        </svg>
                    </button>
                </div>
                <nav class="flex flex-col space-y-4 uppercase font-semibold text-base">
                    <a href="index.php" class="hover:text-brand-white">Home</a>
                    <a href="about_page.php" class="hover:text-brand-white">About Us</a>
                    <a href="project_page.php" class="hover:text-brand-white">Projects</a>
                    <a href="contact_page.php" class="hover:text-brand-white">Contact</a>
                </nav>
                <!-- Language Switcher Mobile -->
                <div x-data="{ lang: 'kh' }" class="flex items-center space-x-1 ml-2">
                    <button @click="lang = lang === 'en' ? 'kh' : 'en'"
                        :aria-label="lang === 'en' ? 'Switch to Khmer' : 'Switch to English'"
                        class="focus:outline-none">
                        <img :src="lang === 'en' ? 'https://flagcdn.com/24x18/gb.png' : 'https://flagcdn.com/24x18/kh.png'"
                            :alt="lang === 'en' ? 'English' : 'Khmer'" class="w-6 h-4 rounded shadow">
                    </button>
                </div>
                <a href="quote_request_page.php">
                    <button
                        class="border border-brand-gold px-3 py-2 lg:px-4 uppercase font-semibold text-sm hover:bg-brand-gold hover:text-white transition-colors">
                        Quote Request
                    </button>
                </a>
            </div>
            <div class="flex-1" @click="open = false"></div>
        </div>
    </header>

    <script src="js/color_config.js"></script>
    </body>

</html>