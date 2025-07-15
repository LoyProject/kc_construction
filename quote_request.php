<?php require_once 'header.php'; ?>

<div class="container mx-auto p-8 sm:p-4 bg-brand-black text-white">
    <div class="max-w-4xl mx-auto p-4 mt-8">
        <h2 class="text-2xl font-bold mb-2" data-translate="sumbit-qoute"></h2>
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
                class="bg-brand-gold text-white font-semibold px-6 py-3 hover:bg-yellow-700 transition" data-translate="send-us">
                SEND US
            </button>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>
