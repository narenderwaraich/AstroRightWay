<!-- Header -->
    <header class="header-top">
        <!-- Header desktop -->
        <div class="container-menu-header">
            

            <div class="wrap_header navbar_background_color">
                <!-- Logo -->
                <a href="/" class="logo" aria-label="home">
                    <img src="/public/images/icons/logo.png" alt="web-logo">
                </a>

                <!-- Menu -->
                <div class="wrap_menu">
                    <nav class="menu">
                        <ul class="main_menu">
                            <li class="{{ (request()->is('product')) ? 'active' : '' }} {{ (request()->is('product/*')) ? 'active' : '' }}">
                                <a href="/product">Products</a>
                                <!-- <ul class="sub_menu">
                                    <li><a href="#">P1</a></li>
                                    <li><a href="#">P2</a></li>
                                    <li><a href="#">P3</a></li>
                                </ul> -->
                            </li>

                            <!-- <li class="dif-menu">
                                <a href="#">Services</a>
                                <ul class="sub_menu">
                                    <li><a href="#">Horoscope</a></li>
                                    <li><a href="#">Kundli</a></li>
                                    <li><a href="#"></a></li>
                                </ul>
                            </li> -->

                            <li class="{{ (request()->is('gallery')) ? 'active' : '' }}">
                                <a href="/gallery">Gallery</a>
                            </li>
                            <li class="{{ (request()->is('youtube-videos')) ? 'active' : '' }}">
                                <a href="/youtube-videos">Videos</a>
                            </li>

                            <!-- <li>
                                <a href="/blog">Ask to Astrologe</a>
                                <ul class="sub_menu">
                                    <li><a href="#">15 min Talk</a></li>
                                    <li><a href="#">30 min Talk</a></li>
                                    <li><a href="#">1 hour Talk</a></li>
                                </ul>
                            </li>
 -->
                             <li class="{{ (request()->is('talk-astro')) ? 'active' : '' }}">
                                <a href="/talk-astro">Talk to Astro</a>
                            </li>
                            <!-- <li class="{{ (request()->is('today-rashifal')) ? 'active' : '' }}">
                                <a href="/today-rashifal">Today Rashifal</a>
                            </li>
                            <li class="{{ (request()->is('covid19-update')) ? 'active' : '' }}">
                                <a href="/covid19-update">COVID19</a>
                            </li> -->
                            <li class="{{ (request()->is('about-us')) ? 'active' : '' }}">
                                <a href="/about-us">About Us</a>
                            </li>

                            <li class="{{ (request()->is('contact-us')) ? 'active' : '' }}">
                                <a href="/contact-us">Contact Us</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Header Icon -->
                <div class="header-icons">
                    <div class="header-wrapicon1 dis-block user-icon">
                         @if(Auth::check())
                        @if(Auth::user()->avatar)
                            <img src="{{asset('/public/images/user/'.Auth::user()->avatar)}}" class="navbar-user-profile-img nav-user-icon" alt="{{Auth::user()->name}}"> 
                         @else
                           <i class="fa fa-user-circle header-icon1 nav-user-icon" aria-hidden="true"></i>
                         @endif
                        @else
                           <i class="fa fa-user-circle header-icon1 nav-user-icon" aria-hidden="true"></i>
                        @endif
                        <ul class="user_menu">
                         @guest
                         <li><a href="/login">Login</a></li>
                            @if (Route::has('register'))
                        <li><a href="/register">Register</a></li>
                            @endif
                         @else
                         <li><a href="/user-profile">Profile</a></li>
                         @if(Auth::user()->role == "astrologer")
                          <li><a href="/astrologer/dashboard">Astrologer</a></li>
                         @endif
                         <li><a href="/member-panel">Member</a></li>
                         <li><a href="/user-order">Orders</a></li>
                          <li class="log-out"><a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}</a>
                          </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
           
                          @endguest
                        </ul>
                    </div>

                    <span class="linedivide1"></span>

                    <div class="header-wrapicon2">
                        <i class="fa fa-shopping-cart header-icon1 js-show-header-dropdown nav-cart-icon"></i>
                        <!-- <img src="/public/images/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON"> -->
                        <span class="header-icons-noti">@if(isset($cartCollection)) {{$cartCollection->count()}} @else 0 @endif</span>

                        <!-- Header cart noti -->
                        <div class="header-cart header-dropdown">
                            <ul class="header-cart-wrapitem">
                                @if(isset($cartCollection))
                                    @foreach($cartCollection as $cart)
                                <li class="header-cart-item">
                                    <div class="header-cart-item-img">
                                        <img src="{{asset('/public/images/products/'.$cart->image)}}" alt="{{$cart->name}}">
                                    </div>

                                    <div class="header-cart-item-txt">
                                        <a href="#" class="header-cart-item-name">
                                            {{$cart->name}}
                                        </a>

                                        <span class="header-cart-item-info">
                                            {{$cart->qty}} x ₹{{$cart->price}}
                                        </span>
                                    </div>
                                </li>
                                     @endforeach
                                        @else
                                        <li class="header-cart-item">
                                            <p>You have no items in your shopping cart</p>
                                        </li>

                                        @endif
                            </ul>
                             @if(isset($cartCollection))
                            <div class="header-cart-total">
                                Total: ₹{{$subTotal}}
                            </div>

                            <div class="header-cart-buttons">
                                <div class="header-cart-wrapbtn">
                                    <!-- Button -->
                                    <a href="/cart" class="btn cart_btn flex-c-m trans-0-4">
                                        View
                                    </a>
                                </div>

                                <div class="header-cart-wrapbtn">
                                    <!-- Button -->
                                    <a href="/clear-cart" class="btn cart_btn flex-c-m trans-0-4">
                                        Clear
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap_header_mobile">
            <!-- Logo moblie -->
            <a href="/" class="logo-mobile">
                <img src="/public/images/icons/logo.png" alt="moblie-web-logo">
            </a>

            <!-- Button show menu -->
            <div class="btn-show-menu">
                <!-- Header Icon mobile -->
                <div class="header-icons-mobile">
                    <div class="header-wrapicon1 dis-block user-icon">
                         @if(Auth::check())
                        @if(Auth::user()->avatar)
                            <img src="{{asset('/public/images/user/'.Auth::user()->avatar)}}" alt="{{Auth::user()->name}}" class="navbar-user-profile-img nav-user-icon"> 
                         @else
                           <i class="fa fa-user-circle header-icon1 nav-user-icon" aria-hidden="true"></i>
                         @endif
                        @else
                           <i class="fa fa-user-circle header-icon1 nav-user-icon" aria-hidden="true"></i>
                        @endif
                        <ul class="user_menu">
                         @guest
                         <li><a href="/login">Login</a></li>
                            @if (Route::has('register'))
                        <li><a href="/register">Register</a></li>
                            @endif
                         @else
                         <li><a href="/user-profile">Profile</a></li>
                         @if(Auth::user()->role == "astrologer")
                          <li><a href="/astrologer/dashboard">Astrologer</a></li>
                         @endif
                         <li><a href="/member-panel">Member</a></li>
                         <li><a href="/user-order">Orders</a></li>
                          <li class="log-out"><a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }} </a>
                          </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
           
                            @endguest
                        </ul>
                    </div>

                    <span class="linedivide2"></span>

                    <div class="header-wrapicon2">
                      <i class="fa fa-shopping-cart header-icon1 js-show-header-dropdown nav-cart-icon"></i>
                        <!-- <img src="/public/images/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON"> -->
                        <span class="header-icons-noti">@if(isset($cartCollection)) {{$cartCollection->count()}} @else 0 @endif</span>

                        <!-- Header cart noti -->
                        <div class="header-cart header-dropdown">
                            <ul class="header-cart-wrapitem">
                                 @if(isset($cartCollection))
                                    @foreach($cartCollection as $cart)
                                <li class="header-cart-item">
                                    <div class="header-cart-item-img">
                                        <img src="{{asset('/public/images/products/'.$cart->image)}}" alt="{{$cart->name}}">
                                    </div>

                                    <div class="header-cart-item-txt">
                                        <a href="#" class="header-cart-item-name">
                                            {{$cart->name}}
                                        </a>

                                        <span class="header-cart-item-info">
                                            {{$cart->qty}} x ₹{{$cart->price}}
                                        </span>
                                    </div>
                                </li>
                                    @endforeach
                                        @else
                                        <li class="header-cart-item">
                                            <p>Cart is empty!</p>
                                        </li>

                                        @endif
                                
                            </ul>
                            @if(isset($cartCollection))
                            <div class="header-cart-total">
                                Total: ₹{{$subTotal}}
                            </div>

                            <div class="header-cart-buttons">
                                <div class="header-cart-wrapbtn">
                                    <!-- Button -->
                                    <a href="/cart" class="btn cart_btn flex-c-m trans-0-4">
                                        View
                                    </a>
                                </div>

                                <div class="header-cart-wrapbtn">
                                    <!-- Button -->
                                    <a href="/clear-cart" class="btn cart_btn flex-c-m trans-0-4">
                                        Clear
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div class="wrap-side-menu" >
            <nav class="side-menu">
                <ul class="main-menu">
                    <li class="item-menu-mobile">
                        <a href="/">Home</a>
                        <!-- <ul class="sub-menu">
                            <li><a href="/">Homepage V1</a></li>
                            <li><a href="/home2">Homepage V2</a></li>
                            <li><a href="/home3">Homepage V3</a></li>
                        </ul>
                        <i class="arrow-main-menu fa fa-angle-right" aria-hidden="true"></i> -->
                    </li>

                    <li class="item-menu-mobile {{ (request()->is('product')) ? 'active' : '' }} {{ (request()->is('product/*')) ? 'active' : '' }}">
                        <a href="/product">Products</a>
                    </li>

                    <li class="item-menu-mobile {{ (request()->is('gallery')) ? 'active' : '' }}">
                        <a href="/gallery">Gallery</a>
                    </li>

                    <li class="item-menu-mobile {{ (request()->is('youtube-videos')) ? 'active' : '' }}">
                        <a href="/youtube-videos">Videos</a>
                    </li>
                    <li class="item-menu-mobile {{ (request()->is('talk-astro')) ? 'active' : '' }}">
                                <a href="/talk-astro">Talk Astro</a>
                    </li>
                    <!-- <li class="item-menu-mobile {{ (request()->is('today-rashifal')) ? 'active' : '' }}">
                                <a href="/today-rashifal">Today Rashifal</a>
                    </li>
                    <li class="item-menu-mobile {{ (request()->is('covid19-update')) ? 'active' : '' }}">
                                <a href="/covid19-update">COVID19</a>
                    </li> -->
                    <li class="item-menu-mobile {{ (request()->is('about-us')) ? 'active' : '' }}">
                        <a href="/about-us">About Us</a>
                    </li>

                    <li class="item-menu-mobile {{ (request()->is('contact-us')) ? 'active' : '' }}">
                        <a href="/contact-us">Contact Us</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>