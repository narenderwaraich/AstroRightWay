<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\UserAddress;
use Auth;
use Toastr;
use Carbon\Carbon;
use Redirect;
use Response;
use App\User;
use PaytmWallet;
use App\EventRegistration;
use App\CartStorage;
use Mail;
use App\Mail\OrderAccept;
use App\Mail\OrderCancel;
use App\Mail\OrderDispatch;
use App\Mail\OrderReject;
use App\Mail\Payments;
use App\Review;
use App\Contact;
use App\OrderItem;
use App\Payment;
use App\BanerSlide;

class OrderController extends Controller
{
    public function register()
    {
        return view('payment_form');
    }

    public function order(Request $request)
    {
 
 
        $this->validate($request, [
            'name' => 'required',
            'mobile_no' => 'required|numeric|digits:10|unique:event_registration,mobile_no',
            'desc' => 'required',
        ]);
 
 
        $input = $request->all();
        $input['order_id'] = uniqid();
        $input['fee'] = 50;
 
 
        EventRegistration::create($input);
 
 
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => $input['order_id'],
          'user' => 'Narender Singh',
          'mobile_number' => '9017109900',
          'email' => 'singh4narender@gmail.com',
          'amount' => $input['fee'],
          'callback_url' => url('api/payment/status')
        ]);
        return $payment->receive();
    }
 
 
    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
 
 
        $response = $transaction->response();
        $order_id = $transaction->getOrderId();
 
 
        if($transaction->isSuccessful()){
          EventRegistration::where('order_id',$order_id)->update(['status'=>2, 'transaction_id'=>$transaction->getTransactionId()]);
 
 
          dd('Payment Successfully Paid.');
        }else if($transaction->isFailed()){
          EventRegistration::where('order_id',$order_id)->update(['status'=>1, 'transaction_id'=>$transaction->getTransactionId()]);
          dd('Payment Failed.');
        }
    }    






    public function takeOrder($id){
        $data['user_id'] = Auth::id();
        $data['product_id'] = $id;

        Order::create($data);
        Toastr::success('Order place successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/');
    }

    public function showOrder(){
        $orders = Order::orderBy('created_at','desc')->paginate(10); //dd($orders);
        foreach ($orders as $order) {
            $userAddress = UserAddress::where('user_id',$order->user_id)->first();
            $order->userAddress = $userAddress->address;
            $order->userCountry = $userAddress->country;
            $order->userState = $userAddress->state;
            $order->userCity = $userAddress->city;
            $order->userPINCode = $userAddress->zipcode;
        }
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.Orders.Show',compact('getOrders','contacts'),['orders' =>$orders]);
    }

    public function showUserOrder(){
        $banner = BanerSlide::where('page_name','=','user-order')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        $userId = Auth::id();
        if(Auth::check()){
            $Orders = Order::where('user_id',$userId)->latest()->paginate(10); //dd($Orders);
            $cartCollection = CartStorage::where('user_id',$userId)->get();
            $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
            return view('user-order',compact('title','description'),compact('Orders'),['banner' =>$banner, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal]);
        }else{
            return redirect()->to('/login');
        }
    }

    public function userOrderDitails($id){
        $banner = BanerSlide::where('page_name','=','order-detail')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        $userId = Auth::id();
        if(Auth::check()){
            $orderItem = OrderItem::where('order_id',$id)->get(); //dd($orderItem);
            $cartCollection = CartStorage::where('user_id',$userId)->get();
            $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
            return view('order-detail',compact('title','description'),compact('orderItem'),['cartCollection' =>$cartCollection, 'subTotal' => $subTotal]);
        }else{
            return redirect()->to('/login');
        }
    }

    public function orderAccept($id){
        $status['status'] = "Accept";
        Order::where('id',$id)->update($status);
        $getUser = Order::find($id);
        $userId = $getUser->user_id;
        $userData = User::find($userId);
        $mailId = $userData->email;
         Mail::to($mailId)->send(new OrderAccept($userData));
        Toastr::success('Order Accept', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/orders/show');
    }
    public function orderDispatch(){
        $allData = request(['dispatch_id','code']); 
        $data  = request(['code']); 
        $orderId = $allData['dispatch_id']; 
        $data['status'] = "Dispatch";
        Order::where('id',$orderId)->update($data);
        $getUser = Order::find($orderId);
        $userId = $getUser->user_id;
        $userData = User::find($userId);
        $mailId = $userData->email;
         Mail::to($mailId)->send(new OrderDispatch($userData));
         //return response()->json(['error' => $invs]);
         return response()->json(['success' => "Order Dispatch"]);
    }

    public function orderCancel($id){
        $order = Order::where('id',$id)->first();
        $status = $order->status;
        if($status == 'Pending' || $status == 'Accept'){
            $data['status'] = "Cancel";
            $order->update($data);
            $getUser = Order::find($id);
            $userId = $getUser->user_id;
            $userData = User::find($userId);
            $mailId = $userData->email;
         Mail::to($mailId)->send(new OrderCancel($userData));
            Toastr::success('Order Cancel', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/user-order');
        }else{
          Toastr::error('Order can not be Cancel', 'Sorry', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/user-order');  
        }
    }

    public function orderReject($id){
        $allData = request(['reject_id','message']); 
        $message  = request(['message']); 
        $orderId = $allData['reject_id']; 
        $data['status'] = "Reject";
        Order::where('id',$orderId)->update($data);
        $getUser = Order::find($orderId);
        $userId = $getUser->user_id;
        $userData = User::find($userId);
        $mailId = $userData->email;
         Mail::to($mailId)->send(new OrderReject($userData,$message));
         return response()->json(['success' => "Order Rejected"]);
    }

    public function orderComplete($id){
        $getOrder = Order::find($id);
        $method = $getOrder->method;
        $userId = $getOrder->user_id;
        $userData = User::find($userId);
        $mailId = $userData->email;
         Mail::to($mailId)->send(new Payments($userData));
         $status['status'] = "Complete";
         Order::where('id',$id)->update($status);
         if($method == "Cash"){
                $data['user_id'] =  $getOrder->user_id;
                $data['order_id'] =  $getOrder->id;
                $data['amount'] =  $getOrder->net_amount;
                $data['payment_method'] =  "Cash";
                $data['transaction_date'] =  Carbon::now();
                $data['transaction_status'] =  "Success";
                $data['order_number'] =  $getOrder->order_number;
                Payment::create($data);
         }
        Toastr::success('Order Complete', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/orders/show');
    }
    
    public function orderTrack($id){
        $banner = BanerSlide::where('page_name','=','track-shiping')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        $order = Order::find($id);
        if($order->status =="Dispatch"){
           $trackCode = $order->code;
           return view('track-shiping',compact('title','description'),['banner' =>$banner, 'trackCode' =>$trackCode]);
        }else{
           Toastr::error('Order not Dispatch', 'Error', ["positionClass" => "toast-bottom-right"]);
           return redirect()->to('/user-order');
        }
    }
}
