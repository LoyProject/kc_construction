<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Quotation</title>
</head>

<body class="bg-brand-black text-white">
    <div id="header" class="sticky top-0 z-50"></div>

    <div class="max-w-4xl mx-auto p-6 mt-8">
        <h2 class="text-2xl font-bold mb-2">SUBMIT A CONSULTATION REQUEST</h2>
        <div class="w-20 h-1 bg-brand-gold mb-8"></div>

        <form class="space-y-6">
            <!-- Row 1: Name + Phone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" placeholder="Name*"
                    class="w-full border border-gray-300 bg-brand-gray px-4 py-2 focus:outline-none focus:ring-1 focus:ring-brand-gold" />
                <input type="text" placeholder="Phone"
                    class="w-full border border-gray-300 bg-brand-gray px-4 py-2 focus:outline-none focus:ring-1 focus:ring-brand-gold" />
            </div>

            <!-- Row 2: Email + Subject -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="email" placeholder="Your Email*"
                    class="w-full border border-gray-300 bg-brand-gray px-4 py-2 focus:outline-none focus:ring-1 focus:ring-brand-gold" />
                <input type="text" placeholder="Subject"
                    class="w-full border border-gray-300 bg-brand-gray px-4 py-2 focus:outline-none focus:ring-1 focus:ring-brand-gold" />
            </div>

            <!-- Address -->
            <textarea placeholder="Address"
                class="w-full border border-gray-300 bg-brand-gray px-4 py-2 h-20 focus:outline-none focus:ring-1 focus:ring-brand-gold"></textarea>

            <!-- Message -->
            <textarea placeholder="Message*"
                class="w-full border border-gray-300 bg-brand-gray px-4 py-2 h-32 focus:outline-none focus:ring-1 focus:ring-brand-gold"></textarea>

            <!-- Button -->
            <button type="submit"
                class="bg-brand-gold text-white font-semibold px-6 py-3 hover:bg-yellow-700 transition">
                SEND US
            </button>
        </form>
    </div>

    <div id="footer"></div>

    <script src="js/color_config.js"></script>
    <script src="js/header_footer.js"></script>
</body>

</html>