<!DOCTYPE html>
<html lang="en" x-data="slider()" x-init="start()">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KC Construction & Design</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style/slide.css">

</head>

<body class="bg-brand-black text-white">

  <div id="header" class="bg-brand-gray sticky top-0 z-50"></div>

  <div class="w-full overflow-hidden relative px-2 sm:px-0">
    <div class="relative w-full">
      <template x-for="(slide, index) in slides" :key="index">
        <div x-show="currentIndex === index" x-transition:enter="transition transform duration-700"
          x-transition:enter-start="opacity-0 -translate-x-10" x-transition:enter-end="opacity-100 translate-x-0"
          x-transition:leave="transition transform duration-700 absolute inset-0"
          x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-10"
          class="w-full mx-auto aspect-[28/10] bg-cover bg-center transition-all duration-700 ease-in-out flex items-center justify-center"
          :style="`background-image: url(${slide.image})`">
          <!-- Overlay Content (optional) -->
        </div>
      </template>

      <!-- Navigation Arrows -->
      <button @click="prev()"
        class="absolute left-1 sm:left-4 top-1/2 -translate-y-1/2 text-white text-xl sm:text-3xl bg-black/40 rounded-full p-1 sm:p-2 hover:bg-black/70 transition z-10">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-8 sm:h-8" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button @click="next()"
        class="absolute right-1 sm:right-4 top-1/2 -translate-y-1/2 text-xl text-brand-green sm:text-3xl bg-black/40 rounded-full p-1 sm:p-2 hover:bg-black/70 transition z-10">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-8 sm:h-8" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </div>

  <section class="py-16 bg-brand-gray text-center">
    <!-- Heading -->
    <div class="mb-8 text-center">
      <h2 class="text-3xl md:text-4xl font-extrabold text-brand-white">
        Create the home you've always wanted
      </h2>

      <!-- Center Icon with Lines -->
      <div class="flex items-center justify-center my-6">
        <span class="w-16 h-px bg-gray-300"></span>
        <span class="mx-4 text-yellow-500 text-xl">
          <i class="fa-solid fa-book-open-reader"></i> <!-- or use your house plan icon -->
        </span>
        <span class="w-16 h-px bg-gray-300"></span>
      </div>

      <!-- Subheading -->
      <p class="text-brand-white/60 max-w-2xl mx-auto text-sm md:text-base">
        More than 100 projects completed in Autora - With over 5 years of combined experience, we have the knowledge to
        serve you.
      </p>
    </div>

    <!-- Features -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto px-4">
      <!-- Feature 1 -->
      <div>
        <div class="flex items-center justify-center mb-4">
          <div class="bg-brand-black w-16 h-16 rounded-full flex items-center justify-center">
            <i class="fas fa-award text-brand-gold text-2xl"></i>
          </div>
        </div>
        <h3 class="text-lg font-semibold text-brand-gold">Design a Beautiful Home</h3>
        <div class="h-[2px] w-10 bg-gray-200 my-2 mx-auto"></div>
        <p class="text-brand-white/60">Design ideas with architects Luxurious and sophisticated design</p>
      </div>

      <!-- Feature 2 -->
      <div>
        <div class="flex items-center justify-center mb-4">
          <div class="bg-brand-black w-16 h-16 rounded-full flex items-center justify-center">
            <i class="fas fa-calendar-alt text-brand-gold text-2xl"></i>
          </div>
        </div>
        <h3 class="text-lg font-semibold text-brand-gold">Professional Construction</h3>
        <div class="h-[2px] w-10 bg-gray-200 my-2 mx-auto"></div>
        <p class="text-brand-white/60">Construction standards according to the Package design drawings from AZ</p>
      </div>

      <!-- Feature 3 -->
      <div>
        <div class="flex items-center justify-center mb-4">
          <div class="bg-brand-black w-16 h-16 rounded-full flex items-center justify-center">
            <i class="fa-solid fa-helmet-safety text-brand-gold text-2xl"></i>
          </div>
        </div>
        <h3 class="text-lg font-semibold text-brand-gold">Finishing Materials for the House testing</h3>
        <div class="h-[2px] w-10 bg-gray-200 my-2 mx-auto"></div>
        <p class="text-brand-white/60">We will advise and provide customers with the best finishing materials and reasonable
          prices.</p>
      </div>
    </div>

    <!-- Button -->
    <div class="mt-12">
      <a href="about_page.php"
        class="bg-brand-gold hover:bg-brand-white text-brand-white hover:text-brand-gold px-6 py-3 font-semibold shadow">
        ABOUT US
      </a>
    </div>
  </section>


  <div class="flex justify-center mt-8 mb-18">
    <nav class="relative w-full">
      <ul class="flex flex-wrap justify-center items-center space-x-2 sm:space-x-4 md:space-x-8 text-sm sm:text-base lg:text-lg font-semibold text-brand-white bg-brand-black rounded-full p-2 sm:p-4 shadow-md transition-all duration-300"
        id="navList">
        <li><a href="#" class="nav-link text-brand-gold font-bold" data-target="all">All</a></li>
        <li><a href="#" class="nav-link text-brand-white hover:text-brand-gold" data-target="villa">Villa</a></li>
        <li><a href="#" class="nav-link text-brand-white hover:text-brand-gold" data-target="castle-mansion">Castle
            Mansion</a></li>
        <li><a href="#" class="nav-link text-brand-white hover:text-brand-gold" data-target="townhouse">Townhouse</a></li>
        <li><a href="#" class="nav-link text-brand-white hover:text-brand-gold"
            data-target="boutique-hotel">Boutique-Hotel</a></li>
        <li><a href="#" class="nav-link text-brand-white hover:text-brand-gold"
            data-target="apartment-office">Apartment-Office</a></li>
        <li><a href="#" class="nav-link text-brand-white hover:text-brand-gold" data-target="flat">Flat</a></li>
      </ul>
      <div id="underline" class="absolute bottom-0 h-0.5 bg-brand-gold transition-all duration-300"></div>
    </nav>
  </div>

  <!-- product_list -->
  <div class="mx-auto p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8" id="products-list"></div>

  <div class="flex justify-center mt-8 mb-12">
    <button id="loadMoreBtn"
      class="bg-brand-gold hover:bg-brand-white text-brand-white hover:text-brand-gold px-6 py-3 font-semibold shadow transition"
      type="button">
      Load More
    </button>
  </div>

  <!-- Fixed Buttons -->
  <div class="fixed bottom-5 right-5 flex flex-col items-end space-y-3 z-50">
    <!-- Fixed Buttons: Call & Scroll to Top, side by side on desktop, stacked on mobile -->
    <div class="flex items-end sm:items-center space-y-3 space-x-3 sm:space-y-0">
      <!-- Call Button -->
      <a href="https://t.me/sovongdy"
        target="_blank"
        class="bg-brand-gold text-white font-bold flex items-center p-4 shadow-md hover:bg-white hover:text-brand-gold transition">
        <i class="fab fa-telegram-plane text-sm mr-2"></i>
        Telegram Chat
      </a>

      <!-- Scroll to Top Button -->
      <button id="scrollTopBtn" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
        class="bg-brand-gold text-white p-4 font-bold hover:bg-white hover:text-brand-gold transition hidden">
        <i class="fas fa-arrow-up"></i>
      </button>
    </div>
  </div>

  <div id="footer"></div>

  <script src="js/color_config.js"></script>
  <script src="js/slide_img.js"></script>
  <script src="js/product_list.js"></script>
  <script src="js/scrollTop_btn.js"></script>
  <script src="js/header_footer.js"></script>

</body>

</html>