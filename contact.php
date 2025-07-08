<?php require_once 'header.php'; ?>

<div class="bg-brand-black text-brand-white">
    
    <!-- Contact Us Page -->
    <!-- <div class="w-full mx-auto flex flex-col md:flex-row items-center justify-between bg-brand-gray px-4 md:px-20 py-8 shadow-md gap-4">
        <div class="text-sm text-gray-500 flex items-center">
            <a href="home" class="hover:text-brand-gold font-semibold text-base" data-translate="home">Home</a>
            <span class="mx-2">|</span>
            <span class="text-brand-gold font-semibold text-xl" data-translate="contact">Contact</span>
        </div>
        <h2 class="text-lg font-bold text-brand-white text-right" data-translate="contact">Contact us</h2>
    </div> -->

    <section class="py-12 px-6 md:px-20">
        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Contact Form -->
            <div class="lg:w-2/3">
                <h2 class="text-2xl font-bold text-brand-gold mb-2" data-translate="contact">Contacts</h2>
                <p class="text-brand-white/80 mb-6" data-translate="contact-discription">Are you interested in finding out how our Construction Services can make
                    your project? For more information on our services please contact us.</p>
                <form id="requestForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="Name*" data-translate="name" class="w-full p-3 bg-brand-gray border border-gray-300 hover:border-2 hover:border-brand-gold" required />
                        <input type="text" name="tell" placeholder="Phone*" data-translate="phone" class="w-full p-3 bg-brand-gray border border-gray-300 hover:border-2 hover:border-brand-gold" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="email" name="email" placeholder="Your Email*" data-translate="email" class="w-full p-3 bg-brand-gray border border-gray-300 hover:border-2 hover:border-brand-gold" required />
                        <input type="text" name="subject" placeholder="Subject*" data-translate="subject" class="w-full p-3 bg-brand-gray border border-gray-300 hover:border-2 hover:border-brand-gold" />
                    </div>

                    <textarea name="message" placeholder="Message*" data-translate="message" rows="6" class="w-full p-3 bg-brand-gray border border-gray-300 hover:border-2 hover:border-brand-gold" required></textarea>

                    <button type="submit" class="bg-brand-gold text-white px-6 py-3 hover:bg-brand-white hover:text-brand-gold" data-translate="send-us">SEND US</button>
                </form>

                <div id="form-message" class="text-green-600 mt-2"></div>
            </div>

            <!-- Info Section -->
            <div class="lg:w-2/3">
                <h2 class="text-2xl font-bold text-brand-gold mb-4" data-translate="information">INFOMATION</h2>
                <div class="bg-brand-gray p-6 shadow-sm">
                    <h3 class="text-sm font-semibold mb-4 border-b pb-2" data-translate="head-office">HEAD OFFICE</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 p-1 bg-gray-900 text-brand-gold mr-2">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>
                            <a id="company-map" target="_blank" class="overflow-hidden text-ellipsis whitespace-nowrap hover:text-brand-gold"><span id="contact-address"></span></a>
                        </li>
                        <li class="flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 p-1 bg-gray-900 text-brand-gold mr-2">
                                <i class="fa-solid fa-phone-volume"></i>
                            </span>
                            <span class="whitespace-nowrap" data-translate="contact-phone"></span>
                            <span id="contact-phone" class="ml-1 overflow-hidden text-ellipsis whitespace-nowrap"></span>
                        </li>
                        <li class="flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 p-1 bg-gray-900 text-brand-gold mr-2">
                                <i class="fa-solid fa-envelope-open-text"></i>
                            </span>
                            <span class="whitespace-nowrap" data-translate="contact-email"></span>
                            <span id="contact-email" class="ml-1 overflow-hidden text-ellipsis whitespace-nowrap"></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once 'footer.php'; ?>
