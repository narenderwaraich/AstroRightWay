<!DOCTYPE html>
<html>
<head>
    <title>Order Email</title>
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

    
<h2>Hi <span style="text-transform: uppercase;">{{$userData->name}}</span></h2>
<br><br><br>
<p>Greetings for choosing AstroRightWay. Your Order Dispatch by AstroRightWay.  

Please click the link below to check your order status.</p>

<br>
<center>
    <br>
    <img src="{{env('APP_URL')}}/public/images/icons/logo.png" style="width: 320px;height: 200px; text-align: center;display: block;margin: auto;">
    <br>
    <a href="{{env('APP_URL')}}/user-order"><button type="button" class="confirm-btn">View Order</button></a>
</center>
<h3>Thanks <br>
Team AstroRightWay</h3>
<p>Kindly contact us at <a href="mailto:info@astrorightway.com">info@astrorightway.com</a> , in case you have any queries </p>    
</body>
</html>