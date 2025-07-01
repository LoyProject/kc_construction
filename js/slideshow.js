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
            $.each(slides, function (i, img) {
                $carousel.append(
                    `<div class="carousel-item${i === 0 ? '' : ' hidden'} duration-700 ease-in-out" data-carousel-item>
              <img src="admin/${img.image_path}" class="absolute block w-full h-full object-cover object-center -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="" style="max-width:1680px;">
            </div>`
                );
                $indicators.append(
                    `<button type="button" class="w-3 h-3 rounded-full${i === 0 ? ' bg-brand-gold' : ' bg-white/50'}" aria-current="${i === 0 ? 'true' : 'false'}" aria-label="Slide ${i + 1}" data-carousel-slide-to="${i}"></button>`
                );
            });

            // Carousel logic
            var current = 0, total = slides.length;
            function showSlide(idx) {
                $('#carousel-images .carousel-item').addClass('hidden').eq(idx).removeClass('hidden');
                $('#carousel-indicators button').removeClass('bg-brand-gold').addClass('bg-white/50').attr('aria-current', 'false');
                $('#carousel-indicators button').eq(idx).removeClass('bg-white/50').addClass('bg-brand-gold').attr('aria-current', 'true');
                current = idx;
            }
            $('#carousel-next').off('click').on('click', function () {
                showSlide((current + 1) % total);
            });
            $('#carousel-prev').off('click').on('click', function () {
                showSlide((current - 1 + total) % total);
            });
            $('#carousel-indicators').off('click', 'button').on('click', 'button', function () {
                showSlide($(this).data('carousel-slide-to'));
            });

            // Optional: Auto-slide every 5 seconds
            if (total > 1) {
                setInterval(function () {
                    showSlide((current + 1) % total);
                }, 5000);
            }
        }
    });
});