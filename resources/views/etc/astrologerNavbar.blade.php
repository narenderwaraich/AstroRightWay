 <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="/astrologer/dashboard"><img src="/public/images/icons/logo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="/astrologer/dashboard"><img src="/public/images/admin/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="/astrologer/dashboard"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>
                    <li>
                        <a href="/"> <i class="menu-icon fa fa-dashboard"></i>Web Dashboard </a>
                    </li>
                    <h3 class="menu-title">Daily Rashifal</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list-alt"></i>Rashi</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-plus"></i><a href="/astrologer/today-rashi/create">Add</a></li>
                            <li><i class="fa fa-table"></i><a href="/astrologer/today-rashi/show">View</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-inr"></i>Payments</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-table"></i><a href="/payment/collect">Paytem</a></li>
                        </ul>
                    </li>


                    <h3 class="menu-title">Account</h3><!-- /.menu-title -->
                    <li>
                        <a href="/astrologer/chat"> <i class="menu-icon fa fa-comments"></i>Chat</a>
                    </li>
                    
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon  fa fa-user"></i>Profile</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa fa-plus"></i><a href="/astrologer/edit/{{ Auth::user()->id }}">Edit</a></li>
                            <!-- <li><i class="fa fa-table"></i><a href="/astrologer/view">View</a></li> -->
                        </ul>
                    </li>
                    @if(isset($astrologer))
                     @if($astrologer->chat_refer == "")
                    <li>
                        <a href="/genrate-chat-refer-code"> <i class="menu-icon fa fa-share-alt"></i>Genrate Refer</a>
                    </li>
                     @else
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon  fa fa-share-alt"></i>Refer Code</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="fa fa-share-alt"></i><a href="#" onclick="copyLink()">Copy Link</a></li>
                                <li><i class="fa fa-whatsapp"></i><a href="whatsapp://send?text=Click on link and chat with me {{env('APP_URL')}}/talk-astro/{{$astrologer->chat_refer}}" data-action="share/whatsapp/share">Share Whatapp</a></li>
                            </ul>
                        </li>
                      
                        <input type="text" value="{{env('APP_URL')}}/talk-astro/{{$astrologer->chat_refer}}" id="linkCopy" style="width: 0px;visibility: hidden;height: 0px;">
                        <script>
                        function copyLink() {
                          var copyText = document.getElementById("linkCopy");
                          copyText.select();
                          copyText.setSelectionRange(0, 99999)
                          document.execCommand("copy");
                          alert("Copied the text: " + copyText.value);
                        }
                        </script>
                     @endif
                    @endif
                    <li>
                        <a href="/astrologer/change-password"> <i class="menu-icon fa fa-key"></i>Change Password</a>
                    </li>

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
                            <a class="dropdown-item media bg-flat-color-2" href="/astrologer/chat">
                                <!-- <span class="photo media-left">@if(empty($chat->userImg))<img src="/public/images/User-Profile/">@else<img src="/public/images/User-Profile/{{$chat->userImg}}">@endif</span> -->
                                <span class="message media-body">
                                    <span class="name float-left">{{$chat->user_name}}</span>
                                        <p>{{$chat->user_message}}</p>
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
                                <a class="nav-link" href="/astrologer/edit/{{ Auth::user()->id }}"><i class="fa fa- user"></i>My Profile</a>

                                <a class="nav-link" href="/astrologer/change-password"><i class="fa fa -cog"></i>Settings</a>

                                <a class="nav-link" href="#"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>

                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->