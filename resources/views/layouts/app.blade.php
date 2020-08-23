<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.name') }} @if(isset($title)) {{$title}} @endif</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@if(isset($description)) {{$description}} @endif">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="google-site-verification" content="iWUQsQ7p7WTzrUNnrsIqY64R-Xks8ZLI45y37updLAQ" />
    <link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
    <link rel="canonical" href="http://www.astrorightway.com/" />
    <link rel="icon" href="/public/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/public/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/public/fonts/themify/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="/public/fonts/elegant-font/html-css/style.css">
    <link rel="stylesheet" type="text/css" href="/public/css-hamburgers/hamburgers.css">
    <link rel="stylesheet" href="/public/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="/public/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="/public/css/design.css">
    <link rel="stylesheet" type="text/css" href="/public/css/custom.css">
    <link rel="stylesheet" type="text/css" href="/public/css/template-main.css">
    <link rel="stylesheet" type="text/css" href="/public/css/responsive.css">
    <script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-160812913-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-160812913-2');
    </script>

    <script data-ad-client="ca-pub-5277251254166016" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body>


@include('etc.navbar')

@yield('content')


<!-- commn code all page -->

    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="fa fa-arrow-up" aria-hidden="true"></i>
        </span>
    </div>

@include('etc.footer')
    <script type="text/javascript" src="/public/bootstrap/js/popper.js"></script>
    <script type="text/javascript" src="/public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/public/slick/slick.min.js"></script>
    <script type="text/javascript" src="/public/js/slick-custom.js"></script>
    <!-- <script type="text/javascript" src="/countdowntime/countdowntime.js"></script> -->
    <script src="/public/js/template-main.js"></script>
    <script src="/public/js/toastr.min.js"></script>
    <script src="/public/js/custom.js"></script>

    {!! Toastr::message() !!}
</body>
</html>
