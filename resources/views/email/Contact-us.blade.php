<!DOCTYPE html>
<html>
<head>
    <title>Query</title>
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

    
<h2>Hi</h2>
<br><br>
<p>
New Query {{$query->name}}.

<br><br>
<strong>Name</strong> : {{$query->name}}
<br>
<strong>Email</strong> : {{$query->email}}
<br>
<strong>Mobile</strong> : {{$query->phone_number}}
 </p>
<br>
<p>{{$query->message}}</p>
<br>

<h3>Thanks</h3>

    
</body>
</html>