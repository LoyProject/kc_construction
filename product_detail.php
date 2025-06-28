<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Projects</title>
</head>

<body class="bg-brand-black text-white">
    <div id="header" class="sticky top-0 z-50"></div>
    <main class="p-4 sm:p-6 md:p-12">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">

            <!-- Left: Main image and thumbnails -->
            <div class="w-full lg:w-2/3">
                <img src="images/pro1.jpg" class="shadow mb-4 w-full max-h-[400px] object-cover rounded" />

                <div class="flex gap-2 overflow-x-auto pb-2">
                    <img src="images/pro1.jpg" alt="Thumb 1"
                        class="w-24 h-16 sm:w-28 sm:h-20 object-cover shadow rounded"/>
                    <img src="images/pro2.jpg" alt="Thumb 2"
                        class="w-24 h-16 sm:w-28 sm:h-20 object-cover shadow rounded"/>
                    <img src="images/pro3.jpg" alt="Thumb 3"
                        class="w-24 h-16 sm:w-28 sm:h-20 object-cover shadow rounded"/>
                    <img src="images/pro4.jpg" alt="Thumb 4"
                        class="w-24 h-16 sm:w-28 sm:h-20 object-cover shadow rounded"/>
                </div>
            </div>

            <!-- Right: Filter Buttons -->
            <div class="w-full lg:w-1/3 space-y-6">
                <div>
                    <h2 class="text-base sm:text-lg font-semibold mb-2 border-b pb-1 border-yellow-500 inline-block">
                        FLOOR NUMBER
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <button class="bg-brand-gray px-3 py-2 hover:bg-yellow-500 hover:text-white text-xs sm:text-sm">1
                            floor</button>
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">2 floors</button>
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">3 floors</button>
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">4 floors</button>
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">11 floors</button>
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">18 floors</button>
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">19 floors</button>
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">21 floors</button>
                    </div>
                </div>

                <div>
                    <h2 class="text-base sm:text-lg font-semibold mb-2 border-b pb-1 border-yellow-500 inline-block">
                        FACADE</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">7m - 8m</button>
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">9m - 10m</button>
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">11m - 12m</button>
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">12m - 13m</button>
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">13m - 14m</button>
                        <button class="bg-brand-gray px-3 py-2 text-xs sm:text-sm">Over 15m</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Title -->
        <div class="mt-8 sm:mt-10">
            <h1 class="text-md sm:text-xl font-semibold text-base lg:text-3xl text-brand-gold">
                Home Design - Exterior Design - Neo Classical Style Villa - ML - Villa - 168 - V143
            </h1>
        </div>

        <!-- Info Table -->
        <div class="mt-4 sm:mt-6">
            <h2 class="text-base sm:text-lg font-bold border-b border-brand-gold inline-block mb-3 sm:mb-4">GENERAL
                INFOMATIONS</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-brand-gray text-sm">
                    <tbody class="divide-y divide-brand-gray">
                        <tr class="border border-brand-gray">
                            <td class="flex items-center gap-2 p-3 min-w-[120px]">
                                <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                    <i class="fas fa-eye text-brand-gold"></i>
                                </span>
                                View
                            </td>
                            <td class="p-3 min-w-[100px] border border-brand-gray">672</td>
                            <td class="flex items-center gap-2 p-3 min-w-[120px]">
                                <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                    <i class="fas fa-user text-brand-gold"></i>
                                </span>
                                Investor
                            </td>
                            <td class="p-3 min-w-[100px] border border-brand-gray">Mr. Vireak</td>
                        </tr>
                        <tr class="border-b border-brand-gray">
                            <td class="flex items-center gap-2 p-3 min-w-[120px]">
                                <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                    <i class="fas fa-bullseye text-brand-gold"></i>
                                </span>
                                Style
                            </td>
                            <td class="p-3 min-w-[100px] border border-brand-gray">Neoclassical</td>
                            <td class="flex items-center gap-2 p-3 min-w-[120px]">
                                <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                    <i class="fas fa-cogs text-brand-gold"></i>
                                </span>
                                Total Area
                            </td>
                            <td class="p-3 min-w-[100px] border border-brand-gray">#</td>
                        </tr>
                        <tr class="border-b border-brand-gray">
                            <td class="flex items-center gap-2 p-3 min-w-[120px]">
                                <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                    <i class="fas fa-chart-bar text-brand-gold"></i>
                                </span>
                                Number of floor
                            </td>
                            <td class="p-3 min-w-[100px] border border-brand-gray">2 floors</td>
                            <td class="flex items-center gap-2 p-3 min-w-[120px]">
                                <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                    <i class="fas fa-calculator text-brand-gold"></i>
                                </span>
                                Implementing unit
                            </td>
                            <td class="p-3 min-w-[100px] border border-brand-gray">#</td>
                        </tr>
                        <tr class="border-b border-brand-gray">
                            <td class="flex items-center gap-2 p-3 min-w-[120px]">
                                <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                    <i class="fas fa-calendar-alt text-brand-gold"></i>
                                </span>
                                Implementa at
                            </td>
                            <td class="p-3 min-w-[100px] border border-brand-gray">2023</td>
                            <td class="flex items-center gap-2 p-3 min-w-[120px]">
                                <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                    <i class="fas fa-bullseye text-brand-gold"></i>
                                </span>
                                Facade
                            </td>
                            <td class="p-3 min-w-[100px] border border-brand-gray">#</td>
                        </tr>
                        <tr>
                            <td class="flex items-center gap-2 p-3 min-w-[120px]">
                                <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                    <i class="fas fa-home text-brand-gold"></i>
                                </span>
                                Types
                            </td>
                            <td class="p-3 min-w-[100px] border border-brand-gray">Villa</td>
                            <td class="flex items-center gap-2 p-3 min-w-[120px]">
                                <span class="flex items-center justify-center w-4 h-4 p-1 text-brand-gold mr-2">
                                    <i class="fas fa-chart-area text-brand-gold"></i>
                                </span>
                                Size
                            </td>
                            <td class="p-3 min-w-[100px] border border-brand-gray">#</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <div id="footer"></div>
</body>


<script src="js/color_config.js"></script>
<script src="js/header_footer.js"></script>

</html>