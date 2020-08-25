<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AstroRightWay Astrologer</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="/public/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/font-awesome.min.css">
    <link rel="stylesheet" href="/public/css/themify-icons.css">
    <link rel="stylesheet" href="/public/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="{{ asset('/public/css/admin-custom.css') }}">
    <link rel="stylesheet" href="/public/css/toastr.min.css">
   <script src="/public/jquery/jquery-3.2.1.min.js"></script>
</head>
<body>
@include('etc.astrologerNavbar')

@yield('content')
@if(isset($astrologer))
<input type="text" name="" value="{{env('APP_URL')}}/talk-astro/{{$astrologer->chat_refer}}" id="linkCopy" style="visibility: hidden;">
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
    <script type="text/javascript" src="/public/bootstrap/js/popper.js"></script>
    <script src="/public/js/plugins.js"></script>
    <script src="/public/js/main.js"></script>
    <script src="/public/js/admin-custom.js"></script>
    <script src="/public/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
</body>     
</html>
