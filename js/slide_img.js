function slider() {
    return {
        currentIndex: 0,
        slides: [
            {
                image: 'images/slide1.jpg',
                // title: 'WELCOME TO MEN LUXURY CONSTRUCTION',
                // subtitle: 'We Build Royal-Class Homes',
                // hotline: 'Hotline: 017/093 630 090'
            },
            {
                image: 'images/slide2.jpg',
                // title: 'ARCHITECTURE & DESIGN',
                // subtitle: 'Elegance, Quality, Durability',
                // hotline: 'Call Us Now'
            },
            {
                image: 'images/slide3.jpg',
                // title: 'YOUR DREAM HOUSE',
                // subtitle: 'Delivered with Perfection',
                // hotline: '017 630 090'
            },
            {
                image: 'images/slide4.jpg',
                // title: 'YOUR DREAM HOUSE',
                // subtitle: 'Delivered with Perfection',
                // hotline: '017 630 090'
            }
        ],
        start() {
            setInterval(() => {
                this.next();
            }, 5000);
        },
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.slides.length;
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length;
        }
    }
}