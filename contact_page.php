<?php require_once 'header_widget.php'; ?>

<div class="bg-brand-black text-brand-white">
    
    <!-- Contact Us Page -->
    <div class="w-full mx-auto flex flex-row items-center justify-between bg-gray-800 px-32 md:px-20 lg:px-32 py-8 shadow-md">
        <div class="text-sm text-gray-500 flex items-center">
            <a href="home_page" class="hover:text-brand-gold font-semibold text-base">Home</a>
            <span class="mx-2">|</span>
            <span class="text-brand-gold font-semibold text-xl">Contact</span>
        </div>
        <h2 class="text-lg font-bold text-brand-white text-right">Contact us</h2>
    </div>

    <section class="py-12 px-6 md:px-20">
        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Contact Form -->
            <div class="lg:w-2/3">
                <h2 class="text-2xl font-bold mb-2">CONTACT US</h2>
                <p class="text-brand-white/80 mb-6">Are you interested in finding out how our Construction Services can make
                    your project? For more information on our services please contact us.</p>

                <form class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="Name*" class="w-full p-3 bg-brand-gray border border-gray-300 hover:border-2 hover:border-brand-gold"
                            required />
                        <input type="text" placeholder="Phone" class="w-full p-3 bg-brand-gray border border-gray-300 hover:border-2 hover:border-brand-gold" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="email" placeholder="Your Email*" class="w-full p-3 bg-brand-gray border border-gray-300 hover:border-2 hover:border-brand-gold"
                            required />
                        <input type="text" placeholder="Subject" class="w-full p-3 bg-brand-gray border border-gray-300 hover:border-2 hover:border-brand-gold" />
                    </div>

                    <textarea placeholder="Message*" rows="6" class="w-full p-3 bg-brand-gray border border-gray-300 hover:border-2 hover:border-brand-gold"
                        required></textarea>

                    <button type="submit" class="bg-brand-gold text-white px-6 py-3 hover:bg-brand-white hover:text-brand-gold">SEND
                        US</button>
                </form>
            </div>

            <!-- Info Section -->
            <div class="lg:w-1/3">
                <h2 class="text-2xl font-bold mb-4">INFOMATION</h2>
                <div class="bg-brand-gray p-6 shadow-sm">
                    <h3 class="text-sm font-semibold mb-4 border-b pb-2">HEAD OFFICE</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 p-1 bg-gray-900 text-brand-gold mr-2">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>
                            <a id="contact-map" target="_blank"><span id="contact-address"></span></a>
                        </li>
                        <li class="flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 p-1 bg-gray-900 text-brand-gold mr-2">
                                <i class="fa-solid fa-phone-volume"></i>
                            </span>
                            <span>CALL US : <span id="contact-phone"></span></span>
                        </li>
                        <li class="flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 p-1 bg-gray-900 text-brand-gold mr-2">
                                <i class="fa-solid fa-envelope-open-text"></i>
                            </span>
                            <span>EMAIL : <span id="contact-email"></span></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once 'footer_widget.php'; ?>
