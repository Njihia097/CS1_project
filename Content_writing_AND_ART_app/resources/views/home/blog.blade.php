<section class="latest-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>From The Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($contents as $content)

            <div class="col-lg-4 col-md-6">
                <div class="single-latest-blog">
                    <img 
                        src="{{ asset('cover_images/' . $content->thumbnail) }}" 
                        alt="Content thumbnail" 
                        class="object-cover w-full rounded-sm h-60"
                    >
                    <div class="text-gray-800 latest-text hover:text-gray-600">
                        <div class="flex space-x-4 tag-list">
                            <div class="flex items-center space-x-2 tag-item">
                                <i class="fa fa-calendar-o"></i>
                                <span>{{ \Carbon\Carbon::parse($content->PublicationDate)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center space-x-2 tag-item">
                                <i class="fa fa-comment-o"></i>
                                <span>5</span>
                            </div>
                        </div>
                        <a href="{{ route('publicView.contentDescription', [$content->ContentID])}}">
                            <h4 class="mt-2 text-lg font-semibold">{{ $content->Title }}</h4>
                        </a>
                        <p class="mt-1 text-sm">{{ Str::limit($content->Description, 100) }}</p>
                    </div>
                </div>
            </div>

            
            @endforeach

            <div class="col-lg-4 col-md-6">
                <div class="single-latest-blog">
                    <img src="img/latest-2.jpg" alt="">
                    <div class="latest-text">
                        <div class="tag-list">
                            <div class="tag-item">
                                <i class="fa fa-calendar-o"></i>
                                May 4,2019
                            </div>
                            <div class="tag-item">
                                <i class="fa fa-comment-o"></i>
                                5
                            </div>
                        </div>
                        <a href="#">
                            <h4>Vogue's Ultimate Guide To Autumn/Winter 2019 Shoes</h4>
                        </a>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-latest-blog">
                    <img src="img/latest-3.jpg" alt="">
                    <div class="latest-text">
                        <div class="tag-list">
                            <div class="tag-item">
                                <i class="fa fa-calendar-o"></i>
                                May 4,2019
                            </div>
                            <div class="tag-item">
                                <i class="fa fa-comment-o"></i>
                                5
                            </div>
                        </div>
                        <a href="#">
                            <h4>How To Brighten Your Wardrobe With A Dash Of Lime</h4>
                        </a>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="benefit-items">
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-benefit">
                        <div class="sb-icon">
                            <img src="img/icon-1.png" alt="">
                        </div>
                        <div class="sb-text">
                            <h6>Free Shipping</h6>
                            <p>For all order over Ksh2000</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-benefit">
                        <div class="sb-icon">
                            <img src="img/icon-2.png" alt="">
                        </div>
                        <div class="sb-text">
                            <h6>Delivery On Time</h6>
                            <p>Caring for your package</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-benefit">
                        <div class="sb-icon">
                            <img src="img/icon-1.png" alt="">
                        </div>
                        <div class="sb-text">
                            <h6>Secure Payment</h6>
                            <p>100% secure payment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>