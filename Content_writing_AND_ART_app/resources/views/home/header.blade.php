<header class="header-section">

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
                <div class="text-right col-lg-3 col-md-3">
                    <ul class="nav-right">
                        <li class="heart-icon">
                            <a href="#">
                                <i class="icon_heart_alt"></i>
                                <span>1</span>
                            </a>
                        </li>
                        <li class="cart-icon">
                            <a href="{{ url('show_cart') }}">
                                <i class="icon_bag_alt"></i>
                                <span>{{ count(session('cart', [])) }}</span>
                            </a>
                            <div class="cart-hover">
                                <div class="select-items">
                                    <table>
                                        <tbody>
                                            @foreach(session('cart', []) as $id => $item)
                                            <tr>
                                                <td class="si-pic"><img src="{{ $item['image'] ?? 'default-image.jpg' }}" alt=""></td>
                                                <td class="si-text">
                                                    <div class="product-selected">
                                                        <p>${{ $item['price'] }} x {{ $item['quantity'] }}</p>
                                                        <h6>{{ $item['art_title'] }}</h6>
                                                    </div>
                                                </td>
                                                <td class="si-close">
                                                    <i class="ti-close" data-id="{{ $id }}"></i>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="select-total">
                                    <span>Total:</span>
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
                            <li><a href="#">arts</a></li>
                            <li><a href="#">Poetry</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('show_cart') }}">Shopping Cart</a></li>
                    <li><a href="{{url ('/view_contact')}}">Contact</a></li>
                    <li><a href="#">Pages</a>
                        <ul class="dropdown">
                            <li><a href="{{url('show_order')}}">Orders</a></li>
                            <li><a href="{{url ('/view_blogpage')}}">Blog</a></li>
                            <li><a href="./faq.html">Faq</a></li>
                            <li><a href="{{url('register')}}">Register</a></li>
                            <li><a href="{{url('login')}}">Login</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div id="mobile-menu-wrap"></div>
        </div>
    </div>
</header>