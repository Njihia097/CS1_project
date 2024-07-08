<header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="ht-left">
                <div class="mail-service">
                    <i class=" fa fa-envelope"></i>
                    creativehub@gmail.com
                </div>
                <div class="phone-service">
                    <i class=" fa fa-phone"></i>
                    +254 712 345 678
                </div>
            </div>
            <div class="ht-right">
                @if (Route::has('login'))
                @auth
                <li class="login-panel">
                <x-app-layout>

                </x-app-layout>
            </li>

                @else
                <a href="{{ route('login') }}" class="login-panel"><i class="fa fa-user"></i>Login</a>
                
                <a href="{{ route('register') }}" class="login-panel"><i class="fa fa-user"></i>Register</a>
                @endauth
                @endif
                <div class="lan-selector">
                    <select class="language_drop" name="countries" id="countries" style="width:300px;">
                        <option value='yt' data-image="img/flag-1.jpg" data-imagecss="flag yt"
                            data-title="English">English</option>
                        <option value='yu' data-image="img/flag-2.jpg" data-imagecss="flag yu"
                            data-title="Bangladesh">German </option>
                    </select>
                </div>
                <div class="top-social">
                    <a href="https://bit.ly/sai4ull"><i class="ti-facebook"></i></a>
                    <a href="https://twitter.com/i/flow/signup"><i class="ti-twitter-alt"></i></a>
                    <a href="#"><i class="ti-linkedin"></i></a>
                    <a href="https://www.pinterest.com/login/"><i class="ti-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="inner-header">
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <div class="logo">
                        
                        
                        <a href="./index.html">
                            <img src="" alt="">
                        </a>
                        
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="advanced-search">
                        <button type="button" class="category-btn">Search</button>
                       
                        <div class="input-group">
                            <input type="text" placeholder="What do you need?">
                            <button type="button"><i class="ti-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 text-right col-md-3">
                    <ul class="nav-right">
                        <li class="heart-icon">
                            <a href="#">
                                <i class="icon_heart_alt"></i>
                                <span>1</span>
                            </a>
                        </li>
                        <li class="cart-icon">
                            <a href="#">
                                <i class="icon_bag_alt"></i>
                                <span>{{ count(session('cart', [])) }}</span>
                            </a>
                            <div class="cart-hover">
                                <div class="select-items">
                                    <table>
                                        <tbody>
                                            @foreach(session('cart', []) as $id => $item)
                                            <tr>
                                                <td class="si-pic"><img src="{{ $item['image'] ?? 'default-image.jpg' }}" alt=""></td> <!-- Assuming you have an image field or a default image -->
                                                <td class="si-text">
                                                    <div class="product-selected">
                                                        <p>${{ $item['price'] }} x {{ $item['quantity'] }}</p>
                                                        <h6>{{ $item['title'] }}</h6>
                                                    </div>
                                                </td>
                                                <td class="si-close">
                                                    <i class="ti-close" data-id="{{ $id }}"></i> <!-- You can add JavaScript to handle removal -->
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="select-total">
                                    <span>total:</span>
                                    <h5>${{ array_reduce(session('cart', []), function($carry, $item) {
                                        return $carry + ($item['price'] * $item['quantity']);
                                    }, 0) }}</h5>
                                </div>
                                <div class="select-button">
                                    <a href="#" class="primary-btn view-card">VIEW CART</a>
                                    <a href="#" class="primary-btn checkout-btn">CHECK OUT</a>
                                </div>
                            </div>
                        </li>
                        <li class="cart-price">
                            ${{ array_reduce(session('cart', []), function($carry, $item) {
                                return $carry + ($item['price'] * $item['quantity']);
                            }, 0) }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-item">
        <div class="container">
            <div class="nav-depart">
                <div class="depart-btn">
                    <i class="ti-menu"></i>
                    <span>All departments</span>
                    <ul class="depart-hover">
                        <li class="active"><a href="#">Science Fiction</a></li>
                        <li><a href="#">Blogging</a></li>
                        <li><a href="#">Technical Writingr</a></li>
                        <li><a href="#">Copywriting</a></li>
                        <li><a href="#">Educational Content</a></li>
                        <li><a href="#">Business Writing</a></li>
                        <li><a href="#">Review Writing</a></li>
                        <li><a href="#">Poetry</a></li>
                        <li><a href="#">Short Story</a></li>
                        <li><a href="#">Adventure</a></li>
                        <li><a href="#">Fantasy</a></li>
                    </ul>
                </div>
            </div>
            <nav class="nav-menu mobile-menu">
                <ul>
                    <li class="active"><a href="{{url ('/view_userpage')}}">Home</a></li>
                    <li><a href="{{url ('/view_artsale')}}">Shop</a></li>
                    <li><a href="#">Collection</a>
                        <ul class="dropdown">
                            <li><a href="#">Content writng</a></li>
                            <li><a href="#">art selling</a></li>
                            <li><a href="#">Poetry</a></li>
                        </ul>
                    </li>
                    <li><a href="{{url ('/view_blogpage')}}">Blog</a></li>
                    <li><a href="{{url ('/view_contact')}}">Contact</a></li>
                    <li><a href="#">Pages</a>
                        <ul class="dropdown">
                            <li><a href="./blog-details.html">Blog Details</a></li>
                            <li><a href="./shopping-cart.html">Shopping Cart</a></li>
                            <li><a href="./check-out.html">Checkout</a></li>
                            <li><a href="./faq.html">Faq</a></li>
                            <li><a href="./register.html">Register</a></li>
                            <li><a href="{{url('')}}">Login</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div id="mobile-menu-wrap"></div>
        </div>
    </div>
</header>