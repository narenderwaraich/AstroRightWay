<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Category;
use App\ProductType;
use App\UserAddress;
use Auth;
use Toastr;
use Cart;
use Carbon\Carbon;
use Redirect;
use Response;
use App\BanerSlide;

class CartController extends Controller
{
    public function addCart(Request $request){
        $userId = Auth::id();
        Cart::session($userId);
        Cart::add();

    }

    public function postAdd(Request $request) {
        $userId = Auth::id(); 
        $product_id = $request->id;
        $product = Product::find($product_id);
          Cart::add(array('id' => $product_id, 'name' => $product->name, 'quantity' => 1, 'price' => $product->price));
          Cart::session($userId)->add($product_id, $product->name, $product->price, 1, array());
        // $session = $request->session(); dd($session);
        // $cartData = ($session->get('cart')) ? $session->get('cart') : array(); //dd($cartData);
        // if (array_key_exists($id, $cartData)) {
        //     $cartData[$id]['qty']++;
        // } else {
        //     $cartData[$id] = array(
        //         'qty' => 1
        //     );
        // }

          $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'VAT 12.5%',
                'type' => 'tax',
                'target' => 'subtotal', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                'value' => '12.5%',
                'attributes' => array( // attributes field is optional
                    'description' => 'Value added tax',
                    'more_data' => 'more data here'
                )
            ));

          $condition2 = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'Express Shipping $50',
                'type' => 'shipping',
                'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                'value' => '+50',
                'order' => 1
            ));

            Cart::condition([$condition, $condition2]);
            Cart::session($userId)->condition($condition); // for a speicifc user's cart

                // $request->session()->put('cart', $cartData);
              //Toastr::success('Product Added Successfully!', 'Success', ["positionClass" => "toast-bottom-right"]);
            return response()->json();
    }

    public function clearCart(){ /// oky tested function
        $userId = Auth::id();
        Cart::clearCartConditions();
        $conditionName = 'Express Shipping $50';
        Cart::removeCartCondition($conditionName);
        Cart::clear();
        Cart::session($userId)->clear();
        Toastr::success('Cart Clear', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/');
    }

    public function removeItem(Request $request){
        $userId = Auth::id();
        $id = $request->id;
        Cart::remove($id);
        $conditionName = 'VAT 12.5%';
        $conditionName2 = 'Express Shipping $50';
        $cartCollection = Cart::getContent();
        $countItem = $cartCollection->count(); 
        if($countItem >1){
            Cart::removeCartCondition($conditionName);
            Cart::removeCartCondition($conditionName2);
            Cart::session($userId)->remove($id); 
                return response()->json();
        }else{
            Cart::removeCartCondition($conditionName);
            Cart::session($userId)->remove($id); 
            return response()->json();
        }
        
    }
    public function updateCart(Request $request,$id){
        $id = $request->id;
        $userId = Auth::id();
        $product = Product::find($id);
        $qty = $request->quantity;
        Cart::update($id, array(
          'quantity' => array(
              'relative' => false,
              'value' => $qty
          ),
        ));

        Cart::session($userId)->update($id, $product->name, $product->price, $qty, array());
   //   Cart::update($id, array(
            //   'quantity' => $qty, // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
            // ));
        Toastr::success('Product Updated Successfully!', 'Success', ["positionClass" => "toast-bottom-right"]);
    }

    public function applyCoupon(){
        $productID = 456;
        $coupon101 = new CartCondition(array(
            'name' => 'COUPON 101',
            'type' => 'coupon',
            'value' => '-5%',
        ));

        Cart::addItemCondition($productID, $coupon101);
    }
    public function viewCart(){
        $banner = BanerSlide::where('page_name','=','cart')->first(); //dd($banner);
        if(Auth::check()){
            $userId = Auth::id();
            $cartCollection = Cart::getContent(); //dd($cartCollection);
            $total = Cart::session($userId)->getTotal(); //dd($total);
            $subTotal = Cart::session($userId)->getSubTotal(); //dd($subTotal);
            $userAddress = UserAddress::where('user_id',$userId)->first();
            $condition = Cart::getCondition('VAT 12.5%'); 
            $taxRate = $condition->getValue();
            $conditionCalculatedValue = $condition->getCalculatedValue($subTotal); //dd($conditionCalculatedValue);
            $condition2 = Cart::getCondition('Express Shipping $50'); 
            $charge = $condition2->getValue(); 
            $shippingCharge = explode('+', $charge)[1]; //dd($shippingCharge);
            return view('cart',['banner' =>$banner, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal, 'total' => $total, 'userAddress' =>$userAddress, 'taxRate' => $taxRate, 'conditionCalculatedValue' => $conditionCalculatedValue, 'shippingCharge' => $shippingCharge]);
        }else{
            return view('cart',['banner' =>$banner]);    
        }
        
    }
}
