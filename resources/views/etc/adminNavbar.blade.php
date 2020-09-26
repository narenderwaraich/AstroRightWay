 <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="/admin"><img src="/public/images/icons/logo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="/admin"><img src="/public/images/admin/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="/admin"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>
                    <h3 class="menu-title">Daily Rashifal</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list-alt"></i>Rashi</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-plus"></i><a href="/today-rashi/create">Add</a></li>
                            <li><i class="fa fa-table"></i><a href="/today-rashi/show">View</a></li>
                        </ul>
                    </li>
                    @if(Auth::user()->role == "admin")
                    <!-- <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list-alt"></i>COVID19</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="fa fa fa-plus"></i><a href="/covid19/create">Add</a></li>
                                <li><i class="fa fa-table"></i><a href="/covid19">View</a></li>
                            </ul>
                    </li> -->
                    @endif
                    <h3 class="menu-title">Products Menu</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list-alt"></i>Category</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-plus"></i><a href="/category/create">Add</a></li>
                            <li><i class="fa fa-table"></i><a href="/category">View</a></li>
                        </ul>
                    </li>
                     @if(Auth::user()->role == "admin")
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>ProductsType</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-plus"></i><a href="/product-type/create">Add</a></li>
                            <li><i class="fa fa-table"></i><a href="/product-type">View</a></li>
                        </ul>
                    </li>
                    @endif
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-product-hunt"></i>Product</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-plus"></i><a href="/product/create">Add</a></li>
                            <li><i class="fa fa-table"></i><a href="/products">View</a></li>
                        </ul>
                    </li>
                     @if(Auth::user()->role == "admin")
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-gift"></i>Coupan</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-plus"></i><a href="/discount/create">Add</a></li>
                            <li><i class="fa fa-table"></i><a href="/discounts">View</a></li>
                        </ul>
                    </li>
                    @endif
                    <h3 class="menu-title">Media</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-picture-o"></i>Gallery</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-plus"></i><a href="/gallery/create">Add</a></li>
                            <li><i class="fa fa-table"></i><a href="/gallery/show">View</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-youtube"></i>Videos</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-plus"></i><a href="/video/create">Add</a></li>
                            <li><i class="fa fa-table"></i><a href="/videos">View</a></li>
                        </ul>
                    </li>
                    


                    <h3 class="menu-title">Order/Payment</h3><!-- /.menu-title -->
                     <li>
                        <a href="/orders/show"> <i class="menu-icon fa fa-shopping-cart"></i>Orders</a>
                    </li>
                    <li>
                        <a href="/products/stock"> <i class="menu-icon fa fa-bar-chart"></i>Stock</a>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-inr"></i>Payments</a>
                        <ul class="sub-menu children dropdown-menu">
                            <!-- <li><i class="fa fa-table"></i><a href="/payment/cash">Cash</a></li> -->
                            <li><i class="fa fa-table"></i><a href="/payment/paytm">Paytem</a></li>
                            <li><i class="fa fa-table"></i><a href="/pay/payment/list">Drect</a></li>
                            <li><i class="fa fa-table"></i><a href="/member/payments">Member</a></li>
                            <!-- <li><i class="fa fa-table"></i><a href="/payment/refund">Refund</a></li> -->
                        </ul>
                    </li>
                     @if(Auth::user()->role == "admin")
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list"></i>Plans</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-plus"></i><a href="/plan/create">Add</a></li>
                            <li><i class="fa fa-table"></i><a href="/plans">View</a></li>
                        </ul>
                    </li>
                    @endif
                    <h3 class="menu-title">Account</h3><!-- /.menu-title -->
                    <li>
                        <a href="/admin/contact-us"> <i class="menu-icon fa fa-address-book"></i>Contacts</a>
                    </li>
                    <li>
                        <a href="/admin/chat"> <i class="menu-icon fa fa-comments"></i>Chat</a>
                    </li>
                     @if(Auth::user()->role == "admin")
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-file"></i>Page</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-plus"></i><a href="/page/create">Add</a></li>
                            <li><i class="fa fa-table"></i><a href="/page/show">View</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cog"></i>Page Setup</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-plus"></i><a href="/page-setup/create">Add</a></li>
                            <li><i class="fa fa-table"></i><a href="/page-setup/show">View</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon  fa fa-themeisle"></i>Tamplate</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-table"></i><a href="/settings">Settings</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon  fa fa-user"></i>User</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-plus"></i><a href="/user/create">Add</a></li>
                            <li><i class="fa fa-users"></i><a href="/user">Users</a></li>
                            <li><i class="fa fa-users"></i><a href="/member/list">Members</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon  fa fa-user"></i>Astrologer</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-plus"></i><a href="/astrologer/create">Add</a></li>
                            <li><i class="fa fa-table"></i><a href="/astrologer/list">View</a></li>
                        </ul>
                    </li>
                    @endif
                    <li>
                        <a href="/change-password/show"> <i class="menu-icon fa fa-key"></i>Change Password</a>
                    </li>
                    @if(Auth::user()->role == "admin")
                    <!--<li>-->
                    <!--    <a href="/millionaire-think/list"> <i class="menu-icon fa "></i></a>-->
                    <!--</li>-->
                    <li>
                        <a href="/send-mail"> <i class="menu-icon fa fa-envelope"></i>Send Mail</a>
                    </li>
                    <li>
                        <a href="/mysql"> <i class="menu-icon fa fa-database"></i>MySql</a>
                    </li>
                    <li>
                        <a href="/change-env-file-data"> <i class="menu-icon fa fa-database"></i>Env File</a>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon  fa fa-database"></i>DB Table</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-table"></i><a href="/astrologer_payments/table/list">Astrologer Payments</a></li>
                            <li><i class="fa fa-table"></i><a href="/member_payments/table/list">Member Payments</a></li>
                            <li><i class="fa fa-table"></i><a href="/payments/table/list">Payments</a></li>
                            <li><i class="fa fa-table"></i><a href="/user_addresses/table/list">User Addresses</a></li>
                            <li><i class="fa fa-table"></i><a href="/user_plans/table/list">User Plans</a></li>
                        </ul>
                    </li>
                    @endif
                    <li>
                        <a style="color: red !important; font-weight: 700 !important; font-size: 20px;" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"> <i class="menu-icon fa fa-arrow-left" style="color: red !important;"></i>{{ __('Logout') }}</a>
                          </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                        <!-- <button class="search-trigger"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div>
 -->
                        <div class="dropdown for-notification">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="count bg-danger">@if(isset($getOrders)) {{$getOrders->count()}} @else 0 @endif</span>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="notification">
                            <p class="red">You have @if(isset($getOrders)) {{$getOrders->count()}} @else 0 @endif Order</p>
                            @if(isset($getOrders))
                                        @foreach ($getOrders as $order)
                            <a class="dropdown-item media bg-flat-color-4" href="/orders/show">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <p>{{ $order->order_number}} <span style="font-size: 9px;">{{$order->created_at->diffForHumans()}}</span></p>
                            </a>
                            @endforeach
                            @endif
                          </div>
                        </div>

                        <div class="dropdown for-message">
                          <button class="btn btn-secondary dropdown-toggle" type="button"
                                id="message"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti-email"></i>
                            <span class="count bg-primary">@if(isset($contacts)) {{$contacts->count()}} @else 0 @endif</span>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="message">
                            <p class="red">You have @if(isset($contacts)) {{$contacts->count()}} @else 0 @endif Mails</p>
                            @if(isset($contacts))
                                        @foreach ($contacts as $contact)
                            <a class="dropdown-item media bg-flat-color-2" href="/admin/contact-us">
                               <!--  <span class="photo media-left">@if(empty($contact->userImg))<img src="/public/images/User-Profile/">@else<img src="/public/images/User-Profile/{{$contact->userImg}}">@endif</span> -->
                                <span class="message media-body">
                                    <span class="name float-left">{{$contact->name}}</span>
                                        <p>{{$contact->message}}</p>
                                </span>
                            </a>
                             @endforeach
                            @endif
                          </div>
                        </div>

                        <div class="dropdown for-message">
                          <button class="btn btn-secondary dropdown-toggle" type="button"
                                id="message"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-comments"></i>
                            <span class="count bg-primary">@if(isset($chats)) {{$chats->count()}} @else 0 @endif</span>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="message">
                            <p class="red">You have @if(isset($chats)) {{$chats->count()}} @else 0 @endif Chat Messages</p>
                            @if(isset($chats))
                                        @foreach ($chats as $chat)
                            <a class="dropdown-item media bg-flat-color-2" href="/chat/reply/{{$chat->id}}">
                                <!-- <span class="photo media-left">@if(empty($chat->userImg))<img src="/public/images/User-Profile/">@else<img src="/public/images/User-Profile/{{$chat->userImg}}">@endif</span> -->
                                <span class="message media-body">
                                    <span class="name float-left">{{$chat->user_name}}</span>
                                        <p>{{ \Illuminate\Support\Str::limit($chat->user_message, 35, '...') }}</p>
                                </span>
                            </a>
                             @endforeach
                            @endif
                          </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="/public/images/admin/admin.jpg" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                                <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a>

                                <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a>

                                <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>

                                <a class="nav-link" href="#"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>

                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->