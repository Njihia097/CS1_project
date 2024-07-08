<section class="hero-section">
    <div class="hero-items owl-carousel">
        <!-- Hero Item 1 -->
        <div class="single-hero-items set-bg" data-setbg="{{ asset('img/hero-1.jpg') }}">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 hero-box">
                        <div class="hero-content">
                            <span></span>
                            <h1>Creative Hub</h1>
                            <p>Join other creators and share your creativity with the world.</p>
                            <a href="{{ route('register') }}" class="primary-btn">Start Writing</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Item 2 -->
        <div class="single-hero-items set-bg" data-setbg="{{ asset('img/hero-2.jpg') }}">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 hero-box">
                        <div class="hero-content">
                            <span></span>
                            <h1>Art Shop</h1>
                            <p style="color: black;">Take this opportunity to find art that speaks to you and purchase it. 
                                Take a step further and register with us to sell your art easily.</p>
                            <a href="{{ url('/view_artsale') }}" class="primary-btn">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include necessary CSS and JS files -->
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $(".hero-items.owl-carousel").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            nav: false,
            dots: true
        });
        
        // Set background images
        $('.set-bg').each(function() {
            var bg = $(this).data('setbg');
            $(this).css('background-image', 'url(' + bg + ')');
        });
    });
</script>
<style>
    .hero-section {
        padding: 50px 0;
    }
    .hero-box {
        background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent background */
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .hero-content {
        padding: 30px;
        text-align: center;
    }
    .single-hero-items {
        padding: 20px;
    }
    .set-bg {
        background-size: cover;
        background-position: center;
        border-radius: 15px; /* Rounded corners for the images */
    }
    .primary-btn {
        background-color: #ff6f61;
        border: none;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 25px;
    }
</style>
