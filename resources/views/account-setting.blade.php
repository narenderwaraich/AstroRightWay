@extends('layouts.app')
@section('content')
	<div class="banner">
	<img src="/public/images/banner/banner-bg.jpg" alt=""/>
	<div class="slider-imge-overlay"></div>
	<div class="caption text-center">
		<div class="container">
			<div class="caption-in">
				<div class="caption-ins">
					<h1>Account<span></span></h1>
					<!--<div class="links"> -->
					<!--	<a href="#" class="btns slider-btn"><span>Button</span></a> -->
					<!--</div>-->
				</div>
			</div>
		</div>
	</div>
</div>
<div class="windows-firm-Box">
	<div class="top-tile">
		Account Settings
	</div>
	<div class="windows-form">
		<div class="menu"><a href="/user-profile-view"><i class="fa fa-user" aria-hidden="true"></i><span> User Profile</span></a></div>
		<div class="menu"><a href="/user-profile"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span> Edit Profile</span></a></div>
		<div class="menu"><a href="/change-password"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span>Change Password</span></a></div>
		@if(empty(Auth::user()->phone_no))
		<div class="menu"><a href="/add-user-address"><i class="fa fa-plus" aria-hidden="true" style="color: #359031;"></i> <span>Add Address</span></a></div>
		@else
		<div class="menu"><a href="/update-user-address"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span>Update Address</span></a></div>
		@endif
		<!-- <div class="menu"><a href="#"><i class="fa fa-remove" aria-hidden="true" style="color: red;"></i> <span>Delete Account</span></a></div> -->
	</div>
</div>
 <script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>
@endsection