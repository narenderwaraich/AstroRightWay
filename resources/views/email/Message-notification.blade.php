<!DOCTYPE html>
<html>
<head>
    <title>Contact Reply</title>
    <style type="text/css">
    .confirm-btn{
    background-color: #ce2350;
    text-transform: uppercase;
    color: #ffffff;
    border: 2px solid #ce2350;
    margin: auto;
    text-align: center;
    border-radius: 5px;
    padding: 8px 12px;
    font-size: 14px;
    font-weight: 600;
    width: auto;
}
.confirm-btn:hover{
   color: #ce2350;
    cursor: pointer;
    background: transparent;
    border: 2px solid #ce2350;
}
input[type="button"]:focus{   
  box-shadow: none !important;
  outline:  none;
}
    </style>
</head>
<body>

    
<h2>Hi <span style="text-transform: uppercase;"></span></h2>
<br><br><br>
<p>
<strong>Name</strong> : {{$user->name}}
<br>
<strong>Email</strong> : {{$user->email}}
<br>
<strong>Gender</strong> : {{$user->gender}}
</p>
<br><br><br>
<p><strong>Message</strong> : {{$chatData->user_message}}</p>
<br>
<center>
    <br>
     <img src="{{env('APP_URL')}}/public/images/icons/logo.png" style="width: 220px;height: 90px; text-align: center;display: block;margin: auto;">
    <br>
</center>
<h3>Thanks <br>
Team AstroRightWay</h3>
    
</body>
</html>