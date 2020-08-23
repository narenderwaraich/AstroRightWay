<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.name') }} @if(isset($title)) {{$title}} @endif</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@if(isset($description)) {{$description}} @endif">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
    <link rel="canonical" href="http://www.astrorightway.com/" />
    <link rel="icon" href="/public/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/public/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/public/fonts/elegant-font/html-css/style.css">
    <link rel="stylesheet" href="/public/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="/public/css/design.css">
    <link rel="stylesheet" type="text/css" href="/public/css/custom.css">
    <link rel="stylesheet" type="text/css" href="/public/css/template-main.css">
    <link rel="stylesheet" type="text/css" href="/public/css/responsive.css">
    <script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>
<style>
.fix-navbar {
    position: fixed !important;
    width: 100% !important;
    top: 0 !important;
    overflow: hidden !important;
    z-index: 1 !important;
    background-color: #FFFFFF !important;
}
.nav-bottom-border {
    border-bottom: 2px solid #ce2350 !important;
}
.nav-text {
    text-transform: uppercase;
    padding-right: 25px !important;
}
.navbar-dark .navbar-nav .nav-link {
    color:#ce2350 !important;
}
.banner {
    margin-top: 59px;
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark static-top nav-bottom-border fix-navbar">
  <div class="container-fluid">
      <ul class="navbar-nav" style="float: right;text-align: right;width: 100%;display: block;">
        <li class="nav-item nav-text">
          <a class="nav-link" href="/login">Login</a>
        </li>
      </ul>
  </div>
</nav>

@if(isset($banner))
<div class="banner">
    <img src="{{asset('/public/images/banner/'.$banner->image)}}" alt="{{$banner->heading}}"/>
    <div class="slider-imge-overlay"></div>
    <div class="caption text-center">
        <div class="container">
            @if($banner->heading)
            <div class="caption-in">
                <div class="caption-ins">
                    <h1 class="text-up">{{$banner->heading}}<span>{{$banner->sub_heading}}</span></h1>
                    @if($banner->button_text)
                    <div class="links"> 
                        <a href="{{$banner->button_link}}" class="btns slider-btn"><span>{{$banner->button_text}}</span></a> 
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@else
<div class="m-t-150"></div>
@endif
<div class="container" style="margin-top: 100px;">
    <h3 class="contact-heading">Get In Touch</h3>
    <p class="contact-sub-heading">We would be happy to help you. You can contact us ..</p>
</div>

    <section class="login-section" style="margin-bottom: 50px;">
        <div class="windows-firm-Box" style="margin-top: 50px;">
            <div class="top-tile">
                Contact Us
            </div>
        <div class="windows-form">
            
            <form method="POST" action="/millionairethink/submit">
                @csrf
            <input class="form-control windows-form-input {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{old('name')}}" placeholder="Name">
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $errors->first('name') }}</strong>
                    </span>
                 @endif
            <input class="form-control windows-form-input {{ $errors->has('phone') ? ' is-invalid' : '' }}" type="number" name="phone" value="{{old('phone')}}" placeholder="Mobile">
                @if ($errors->has('phone'))
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                 @endif
            <input class="form-control windows-form-input {{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" value="{{old('email')}}" placeholder="Email">
                            @if ($errors->has('email'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                            @endif
           <textarea class="form-control windows-form-input {{ $errors->has('message') ? ' is-invalid' : '' }}" name="message" placeholder="Message" rows="5"></textarea>
                @if ($errors->has('message'))
                   <span class="invalid-feedback" role="alert">
                       <strong>{{ $errors->first('message') }}</strong>
                   </span>
               @endif

            <button type="submit" class="btn btn-style btn-top" >Send</button>
        </form>
        
            </div>
        </div>
    </section>

<!-- commn code all page -->

    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="fa fa-arrow-up" aria-hidden="true"></i>
        </span>
    </div>

    <script type="text/javascript" src="/public/bootstrap/js/popper.js"></script>
    <script type="text/javascript" src="/public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/public/js/template-main.js"></script>
    <script src="/public/js/toastr.min.js"></script>
    <script src="/public/js/custom.js"></script>

    {!! Toastr::message() !!}
</body>
</html>
