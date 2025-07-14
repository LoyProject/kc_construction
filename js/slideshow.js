$(document).ready(function () {
    $.ajax({
        url: 'backend/process_fetch_achievements.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            var $carousel = $('#carousel-images');
            var $indicators = $('#carousel-indicators');
            $carousel.empty();
            $indicators.empty();

            var slides = data.slideshow || [];
            if (slides.length === 0) return;

            // Append slides and indicators
            $.each(slides, function (i, img) {
                $carousel.append(`
                    <div class="carousel-item ${i === 0 ? '' : 'hidden'} absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out" data-carousel-item>
                        <img src="${img.image_path}" alt="Slide ${i + 1}" class="w-full h-full object-cover" />
                    </div>
                `);

                $indicators.append(`
          <button type="button"
            class="w-3 h-3 rounded-full transition-colors duration-300 ${i === 0 ? 'bg-brand-gold' : 'bg-white/50'}"
            aria-current="${i === 0 ? 'true' : 'false'}"
            aria-label="Slide ${i + 1}"
            data-carousel-slide-to="${i}"></button>
        `);
            });

            // Carousel Logic
            var current = 0, total = slides.length;

            function showSlide(idx) {
                $('#carousel-images .carousel-item')
                    .addClass('hidden')
                    .eq(idx).removeClass('hidden');

                $('#carousel-indicators button')
                    .removeClass('bg-brand-gold').addClass('bg-white/50')
                    .attr('aria-current', 'false');

                $('#carousel-indicators button')
                    .eq(idx).removeClass('bg-white/50').addClass('bg-brand-gold')
                    .attr('aria-current', 'true');

                current = idx;
            }

            // Prev/Next handlers
            $('#carousel-prev').off('click').on('click', function () {
                showSlide((current - 1 + total) % total);
            });

            $('#carousel-next').off('click').on('click', function () {
                showSlide((current + 1) % total);
            });

            $('#carousel-indicators').off('click', 'button').on('click', 'button', function () {
                showSlide($(this).data('carousel-slide-to'));
            });

            // Auto-slide
            if (total > 1) {
                setInterval(function () {
                    showSlide((current + 1) % total);
                }, 5000);
            }
        }
    });
});
