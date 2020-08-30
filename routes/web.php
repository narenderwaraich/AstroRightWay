<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/test','AdminController@edit');


Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('AdminLogin');
Route::post('admin/login', 'Auth\LoginController@login')->name('auth.login');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::get('auth/google', 'GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'GoogleController@handleGoogleCallback');

Auth::routes();

Route::get('/admin','AdminController@homePage');
Route::get('/user/suspend-user/{id}','AdminController@enableDisableUser');
Route::get('/user/verified/{id}','AdminController@verifyUser');

Route::get('/getDashboardDetail','AdminController@dashboard');

Route::any('/user/search','AdminController@SearchData');

Route::get('/mysql','AdminController@openMySql');
Route::post('mysql','AdminController@openQueryMySql');

Route::get('/products', 'ProductController@index');
Route::get('/product/get', 'ProductController@getData');
Route::get('/product/create', 'ProductController@create');
Route::post('product/create', 'ProductController@store');
Route::get('/product/edit/{id}', 'ProductController@edit');
Route::post('/product/update/{id}', 'ProductController@update');
Route::get('/product/delete/{id}', 'ProductController@destroy');
Route::get('/products/stock', 'ProductController@productStock');


// category

Route::get('/category', 'CategoryController@index');
Route::get('/category/get', 'CategoryController@getData');
Route::get('/category/create', 'CategoryController@create');
Route::post('category/create', 'CategoryController@store');
Route::get('/category/edit/{id}', 'CategoryController@edit');
Route::post('category/update/{id}', 'CategoryController@update');
Route::get('/category/delete/{id}', 'CategoryController@destroy');

Route::get('/product-type', 'ProductTypeController@index');
Route::get('/product-type/get', 'ProductTypeController@getData');
Route::get('/product-type/create', 'ProductTypeController@create');
Route::post('product-type/create', 'ProductTypeController@store');
Route::get('/product-type/edit/{id}', 'ProductTypeController@edit');
Route::post('/product-type/update/{id}', 'ProductTypeController@update');
Route::get('/product-type/delete/{id}', 'ProductTypeController@destroy');
Route::post('/deleteImage', 'ProductController@destroyImage');

// DiscountCoupan

Route::get('/discounts', 'DiscountCoupanController@index');
Route::get('/discount/get', 'DiscountCoupanController@getData');
Route::get('/discount/create', 'DiscountCoupanController@create');
Route::post('discount/create', 'DiscountCoupanController@store');
Route::get('/discount/edit/{id}', 'DiscountCoupanController@edit');
Route::post('/discount/update/{id}', 'DiscountCoupanController@update');
Route::get('/discount/delete/{id}', 'DiscountCoupanController@destroy');


Route::get('/orders/show', 'OrderController@showOrder');
Route::get('/orders/accept/{id}', 'OrderController@orderAccept');
Route::post('orders/dispatch', 'OrderController@orderDispatch');
Route::get('/orders/track/{id}', 'OrderController@orderTrack');
Route::get('/orders/complete/{id}', 'OrderController@orderComplete');
Route::post('/orders/reject', 'OrderController@orderReject');
Route::get('/cancel-order/{id}', 'OrderController@orderCancel');

Route::get('/user', 'AdminController@index');
Route::get('/user/{status}', 'AdminController@userWithStatus');
Route::get('/user/{id}/view', 'AdminController@userView');
Route::get('/user/create', 'AdminController@create');
Route::post('user/create', 'AdminController@store');
Route::get('/user/edit/{id}', 'AdminController@edit');
Route::post('/user/update/{id}', 'AdminController@update');
Route::get('/user/delete/{id}', 'AdminController@destroy');
Route::get('/change-password/show', 'AdminController@changePassGet');
Route::post('change-password', 'AdminController@changePass');
		// Web Settings
Route::get('/settings', 'AdminController@settingPage');
Route::post('settings/update', 'AdminController@settingUpdate');

//// Change Admin Mail
Route::get('/change-env-file-data','AdminController@envData');
Route::post('change-env-file-data','AdminController@changeEnvData');
Route::get('/clear-cache','AdminController@clearCache');
Route::get('/clear-config','AdminController@clearConfig');

Route::get('/plan/create', 'ChatPlanController@create');
Route::post('/plan/create', 'ChatPlanController@store');
Route::get('/plan/edit/{id}', 'ChatPlanController@edit');
Route::post('/plan/update/{id}', 'ChatPlanController@update');
Route::get('/plans', 'ChatPlanController@index');
Route::get('/plan/delete/{id}', 'ChatPlanController@destroy');

//Page Add

Route::get('/page/create', 'PageController@create');
Route::post('/page/create', 'PageController@store');
Route::get('/page/edit/{id}', 'PageController@edit');
Route::post('/page/update/{id}', 'PageController@update');
Route::get('/page/show', 'PageController@index');
Route::get('/page/delete/{id}', 'PageController@destroy');

///Page Setup
Route::get('/page-setup/show', 'AdminController@pageIndex');
Route::get('/page-setup/create', 'AdminController@pageCreate');
Route::post('page-setup/create', 'AdminController@pageStore');
Route::get('/page-setup/edit/{id}', 'AdminController@pageEdit');
Route::post('/page-setup/update/{id}', 'AdminController@pageUpdate');
Route::get('/page-setup/delete/{id}', 'AdminController@pageDestroy');

// user plan
//Route::get('/user/plan/edit/{id}','AdminController@userPlanEdit');
Route::get('/user/plan-active/{id}','AdminController@userPlanActive');
Route::get('/user/plan-inactive/{id}','AdminController@userPlanInActive');

Route::get('/user/payment/mark-success/{id}','AdminController@userPaymentMarkSuccess');
Route::get('/user/payment/manual/{id}','AdminController@userPaymentManual');

Route::get('/member/payment/mark-success/{id}','AdminController@memberPaymentMarkSuccess');
Route::get('/member/payment/manual/{id}','AdminController@memberPaymentManual');

Route::get('/files', 'FileEntriesController@index');
Route::get('/files/create', 'FileEntriesController@create');
Route::post('/files/upload-file', 'FileEntriesController@uploadFile');

Route::get('/gallery/show', 'GelleryController@index');
Route::get('/gallery/get', 'GelleryController@getData');
Route::get('/gallery/create', 'GelleryController@create');
Route::post('gallery/create', 'GelleryController@store');
Route::get('/gallery/edit/{id}', 'GelleryController@edit');
Route::post('/gallery/update/{id}', 'GelleryController@update');
Route::get('/gallery/delete/{id}', 'GelleryController@destroy');

Route::get('/videos', 'YoutubeController@index');
Route::get('/video/get', 'YoutubeController@getData');
Route::get('/video/create', 'YoutubeController@create');
Route::post('video/create', 'YoutubeController@store');
Route::get('/video/edit/{id}', 'YoutubeController@edit');
Route::post('/video/update/{id}', 'YoutubeController@update');
Route::get('/video/delete/{id}', 'YoutubeController@destroy');
Route::get('/youtube-videos', 'YoutubeController@showAll');




Route::get('/homepage', 'PostController@home');

// Route::get('/admin-home', function () {
//     return view('Admin.index');
// });

// Route::group(['middleware' => 'auth'], function () {
    
// });



Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');


Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/{any}', function () {
//   return redirect('/admin');
// })->where('any', '.*');

/// Test Data



Route::get('/', 'HomeController@index');

//User Profile Controller
Route::get('/user-profile','UserProfileControler@viewProfile');
Route::post('user-profile-update/{id}','UserProfileControler@updateProfile');
Route::get('/account-setting','UserProfileControler@accountSetting');
Route::get('/change-password','UserProfileControler@getChangePass');
Route::post('change-password','UserProfileControler@updatePass');
Route::get('/add-user-address','UserProfileControler@getAddress');
Route::post('add-user-address/{id}','UserProfileControler@storeAddress');
Route::get('/update-user-address','UserProfileControler@getUpdateAddress');
Route::post('update-user-address/{id}','UserProfileControler@updateAddress');

///Session Controller
Route::get('/login','SessionController@loginView')->name('login');
Route::post('login','SessionController@loginId');
Route::post('request/verifyemail','SessionController@resendVerifyMail');


//Register Controller
Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');
Route::post('/verify-Otp', 'Auth\RegisterController@verifyOtp');
Route::get('/resend-Otp/{id}', 'Auth\RegisterController@resendOtp');

Route::get('/user/verified-mail/{id}', 'AdminController@verifyMailReminder');
//Product Controller
Route::get('/product','ProductController@productView');
Route::get('/product/category/{name}','ProductController@categoryView');
Route::get('/product-details/{id}', 'ProductController@productDetails');
Route::get('/show-all-product','ProductController@viewProduct');
Route::get('/view-product-details/{id}','ProductController@viewProductDetail');



Route::get('/getProduct/{id}','ProductController@getProduct');


//Payments Controller 
Route::post('check-out','PaymentController@chossePaymentMethod');
Route::post('check-out-pay','PaymentController@PaymentView');
Route::get('/cash/{amount}/pay','PaymentController@cashPayment');
Route::get('/paytm/{amount}/pay','PaymentController@paytmPay');
Route::get('/payment/cash','PaymentController@cashShowPayments');
Route::get('/payment/paytm','PaymentController@paytmShowPayments');
Route::get('/payment/{status}/paytm','PaymentController@paytmWithStatus');
Route::get('/payment/field/paytm','PaymentController@paytmShowPayments');
Route::get('/payment/refund','PaymentController@refundShowPayments');
Route::get('/payment/refund/{id}','PaymentController@paytemRefundBack');

Route::resource('/orders', 'PaymentController');
Route::post('/paytm-callback', 'PaymentController@paytmCallback');


///Order Controller
Route::get('/place-order/{id}','OrderController@takeOrder');
Route::get('/show-orders','OrderController@showOrder');
Route::get('/user-order','OrderController@showUserOrder');
Route::get('/order-details/{id}','OrderController@userOrderDitails');

Route::get('eventRegistration', 'OrderController@register');
Route::post('paytmPayment', 'OrderController@order');
Route::post('payment/status', 'OrderController@paymentCallback');


//// ReviewController 
Route::get('/feed-back/{id}','ReviewController@create');
Route::post('/store-review/{id}','ReviewController@store');

/// Country State City
Route::get('get-state-list','APIController@getStateList');
Route::get('get-city-list','APIController@getCityList');


/// Cart Storage Controller
Route::post('cart', 'CartStorageController@store');
Route::post('add_cart/{id}', 'CartStorageController@addCartWithQty');
Route::get('/cart', 'CartStorageController@show');
Route::get('/clear-cart', 'CartStorageController@clearCart');
Route::post('coupan-apply', 'CartStorageController@putCoupan');



/// Serach Controller
Route::any('/products/search','SearchController@SearchData');


Route::post('cart/update/{id}','CartStorageController@update');
Route::get('/cart/deleteItem/{id}','CartStorageController@destroy');

/// Contact us controller
Route::post('contact-us','ContactController@contactUs');
Route::get('/contact-us','ContactController@get');
Route::post('contactUs','ContactController@store');
Route::get('/admin/contact-us','ContactController@getContact');
Route::get('/contact/reply/{id}','ContactController@contactReplyGet');
Route::post('contact-reply','ContactController@contactReply');

//// send manumal mail
Route::get('/send-mail','ContactController@sendMailView');
Route::post('send-mail','ContactController@sendMail');

Route::post('send-notificaton-mail','ContactController@SendNotificationMail');

Route::get('/about-us','ContactController@aboutPage');
Route::get('/gallery','GelleryController@galleryPage');
Route::get('/privacy-policy', 'HomeController@privacyPolicy');
Route::get('/term-of-services', 'HomeController@termService');

Route::get('/talk-astro','ChatController@create');
Route::post('send-message','ChatController@store');
Route::get('/talk-astro/{refer}','ChatController@createReferMesg');
Route::post('refer-send-message','ChatController@storeReferMesg');
Route::get('/admin/chat','ChatController@showList');
Route::get('/admin/{status}/chat','ChatController@listWithStatus');
Route::get('/chat/reply/{id}','ChatController@userMessage');
Route::post('/chat-reply/{id}','ChatController@astroReply');
Route::post('message-transfer','ChatController@transferMessage');
Route::get('/chat/view/{id}','ChatController@viewChat');
Route::get('/chat/status/mark-sent/{id}','ChatController@markSentChat');
Route::get('/chat/status/mark-reply/{id}','ChatController@markReplyChat');

Route::get('/buy/plan','UserPlanController@create');
Route::get('/buy-plan/{id}','UserPlanController@buyPlan');
Route::post('/paytm-call-back', 'UserPlanController@paytmCallback');

// today rashifal
Route::get('/today-rashifal','RashifalController@todayRashi');
Route::get('/today-rashifal/{name}','RashifalController@rashifalWithName');
Route::get('/today-rashi/show','RashifalController@index');
Route::get('/today-rashi/create','RashifalController@create');
Route::post('/today-rashi/create','RashifalController@store');
Route::get('/today-rashi/edit/{id}','RashifalController@edit');
Route::post('/today-rashi/update/{id}','RashifalController@update');
Route::get('/today-rashi/delete/{id}','RashifalController@destroy');

Route::get('astrologer/today-rashi/show','RashifalController@astrologerIndex');
Route::get('astrologer/today-rashi/create','RashifalController@astrologerCreate');
Route::get('astrologer/today-rashi/edit/{id}','RashifalController@astrologerEdit');

// COVID19

Route::get('/covid19', 'Covid19Controller@index');
Route::get('/covid19/create', 'Covid19Controller@create');
Route::post('covid19/create', 'Covid19Controller@store');
Route::get('/covid19/edit/{id}', 'Covid19Controller@edit');
Route::post('covid19/update/{id}', 'Covid19Controller@update');
Route::get('/covid19/delete/{id}', 'Covid19Controller@destroy');
Route::get('/covid19-update', 'Covid19Controller@dailyUpdate');


// Pay Payments Direct
Route::get('/pay/payment/list', 'DirectPaymentController@showPayment');
Route::get('/pay/{status}/payment', 'DirectPaymentController@showPaymentStatus');
Route::get('/pay/payment/field/list', 'DirectPaymentController@fieldPayment');
Route::get('/pay/payment', 'DirectPaymentController@create');
Route::post('pay/payment', 'DirectPaymentController@paytmPay');
Route::post('/direct-payment-call-back', 'DirectPaymentController@paytmCallback');

Route::get('/join-astrologer','AstrologerController@create');
Route::post('join-astrologer','AstrologerController@store');
Route::get('/verify/astrologer/{token}', 'AstrologerController@verify');
Route::get('/astrologer/dashboard','AstrologerController@dashboard');
Route::post('pay/fee', 'AstrologerController@paytmPay');
Route::post('/astrologer/payment/status', 'AstrologerController@paytmCallback');

Route::get('/astrologer/edit/{id}','AstrologerController@edit');
Route::post('astrologer/update/{id}', 'AstrologerController@update');

Route::get('/astrologer/chat','ChatController@astrologerChatList');
Route::get('/astrologer/chat/reply/{id}','ChatController@astroUserMessage');
// Route::post('/chat-reply/{id}','ChatController@astroReply');
Route::get('/astrologer/chat/view/{id}','ChatController@viewClientChat');

Route::get('/astrologer/create','AstrologerController@addAstrologer');
Route::get('/astrologer/list','AstrologerController@astrologerList');
Route::get('/astrologer/verified/{id}','AstrologerController@verifyAstrologer');
Route::get('/astrologer/delete/{id}','AstrologerController@destroy');
Route::get('/payment/collect','AstrologerController@collectPayment');
Route::get('/astrologer/change-password/','AstrologerController@changeAstrologerPassword');
Route::get('/genrate-chat-refer-code','AstrologerController@genrateChatRefer');

///Member 
Route::get('/join-member','MemberJoinController@create');
Route::get('/join-member/{code}','MemberJoinController@joinWithCode');
Route::post('join-member','MemberJoinController@store');
Route::post('make-member','MemberJoinController@userWithMember');
Route::get('/member-panel','MemberJoinController@index');
Route::get('/join-member/pay/payment','MemberJoinController@getPay');
Route::post('join-member/payment','MemberJoinController@paytmPay');
Route::post('member-update/{id}','MemberJoinController@update');
Route::get('/member/payments','MemberJoinController@paytmShow');
Route::get('/member/payment/{status}','MemberJoinController@withStatus');
Route::get('/member/list','MemberJoinController@memberShow');
Route::get('/member/{status}/list','MemberJoinController@memberWithStatus');
Route::get('/help-plan','MemberJoinController@memberPlan');
Route::get('/member/delete/{id}','MemberJoinController@destroy');
Route::get('/member/suspend-member/{id}','MemberJoinController@enableDisableMember');
Route::get('/member/verified/{id}','MemberJoinController@verifyMember');
Route::post('/member-payment-status', 'MemberJoinController@paytmCallback');
Route::any('/member/search','MemberJoinController@SearchData');
Route::get('/member/with-member/{id}','MemberJoinController@memberWithMember');

//// millionairethink
Route::get('/millionaire-think/data-list','MillionairethinkController@index');
Route::get('/millionaire-think/list','MillionairethinkController@show');
Route::get('/millionaire-think','MillionairethinkController@create');
Route::post('/millionairethink/submit', 'MillionairethinkController@store');

Route::get('/astrologer_payments/table/list','AdminController@astrologerPayments');
Route::get('/member_payments/table/list','AdminController@memberPayments');
Route::get('/payments/table/list','AdminController@paymentTable');
Route::get('/user_addresses/table/list','AdminController@userAddresses');
Route::get('/user_plans/table/list','AdminController@userPlans');