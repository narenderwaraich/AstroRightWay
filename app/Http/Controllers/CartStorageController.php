<?php

namespace App\Http\Controllers;

use App\CartStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Category;
use App\ProductType;
use App\UserAddress;
use App\Setting;
use App\DiscountCoupan;
use Auth;
use Toastr;
use Carbon\Carbon;
use Redirect;
use Response;
use App\BanerSlide;

class CartStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $setting = Setting::where('id',1)->first();
            $product_id = $request->id;
            $userId = Auth::id();
            $storeCheck = CartStorage::where('user_id',$userId)->where('product_id',$product_id)->first();
            if($storeCheck){
                    $productName = $storeCheck->name;
                    $errorTxt = "product alrady add please check cart";
                  $msg = $errorTxt;
                  return response()->json(['error' => $msg]);    
            }else{
            $product = Product::find($product_id);
            $price = $product->price;
            $qty = 1;
            // $taxRate = $setting->tax_rate;
            $shipCharge = $setting->ship_charge;
            // $tax = $price * $taxRate / 100;
            $subTotal = $price * $qty;
            $total = $subTotal + $shipCharge;
            
            $data['product_id'] = $product_id;
            $data['user_id'] = $userId;
            $data['product_name'] = $product->name;
            $data['price'] = $price;
            $data['qty'] = $qty;
            $data['description'] = $product->description;
            $data['image'] = $product->image;
            $data['subtotal'] = $subTotal;
            // $data['tax'] = $tax;
            // $data['tax_rate'] = $taxRate;
            $data['ship_charge'] = $shipCharge;
            $data['net_amount'] = $total;
            $data['total'] = $total;
            //dd($data);
            CartStorage::create($data);
            return response()->json(['success' => "Product Add"]);
            }
        }else{
            return response()->json(['error' => "Please Login First"]);
        }
        
    }
    
    public function addCartWithQty(Request $request, $id)
     {
      if (Auth::check()) {
        $setting = Setting::where('id',1)->first();
        $userId = Auth::id();
        $storeCheck = CartStorage::where('user_id',$userId)->where('product_id',$id)->first();
        if($storeCheck){
                $productName = $storeCheck->name;
              Toastr::error('Product alrady add please check cart', 'Error', ["positionClass" => "toast-top-right"]);
                return back();   
        }else{
        $product = Product::find($id);
        $price = $product->price;
        $qty = $request->qty;
        //$taxRate = $setting->tax_rate;
        $shipCharge = $setting->ship_charge;
        //$tax = $price * $taxRate / 100;
        $subTotal = $price * $qty;
        $total = $subTotal + $shipCharge;
        
        $data['product_id'] = $id;
        $data['user_id'] = $userId;
        $data['product_name'] = $product->name;
        $data['price'] = $price;
        $data['qty'] = $qty;
        $data['description'] = $product->description;
        $data['image'] = $product->image;
        $data['subtotal'] = $subTotal;
        $data['total'] = $subTotal;
        // $data['tax'] = $tax;
        // $data['tax_rate'] = $taxRate;
        $data['ship_charge'] = $shipCharge;
        $data['net_amount'] = $total;
        //dd($data);
        CartStorage::create($data);
        Toastr::success('Product Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/cart');
        }
      }else{
        Toastr::error('Please login first', 'Error', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/login');
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CartStorage  $cartStorage
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $banner = BanerSlide::where('page_name','=','')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        $userId = Auth::id();
        $check = CartStorage::where('user_id',$userId)->first();
        $storage = CartStorage::where('user_id',$userId)->get(); //dd($storage);
        $userAddress = UserAddress::where('user_id',$userId)->first();
        $id = 1;
        $setting = Setting::where('id',$id)->first();
        if(Auth::check()){  
            $userId = Auth::id();
            $cartCollection = CartStorage::where('user_id',$userId)->get();
            $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
            if(!$check){
                  Toastr::error('You have no items in your shopping cart', 'Error', ["positionClass" => "toast-top-right"]);
                    return redirect()->to('/');
                }else{
                  return view('cart',compact('title','description'),['banner' =>$banner, 'storage' => $storage, 'userAddress' =>$userAddress, 'setting' =>$setting, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal]);
                }      
        }else{
            if(!$check){
                Toastr::error('You have no items in your shopping cart', 'Error', ["positionClass" => "toast-top-right"]);
                    return redirect()->to('/');
                }else{
                    return view('cart',compact('title','description'),['banner' =>$banner, 'storage' => $storage, 'userAddress' =>$userAddress, 'setting' =>$setting]);
            }      
        }
        // foreach ($storage as $storageData) {
        //     $tax = $storage ? DB::table("cart_storages")->where('user_id',$userId)->sum('tax') : '';
        //     $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
        //     $Total = DB::table("cart_storages")->where('user_id',$userId)->sum('net_amount');
        // }
    }

    public function productShow($id)
    {
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {  
        $setting = Setting::where('id',1)->first();
        $storeProduct = CartStorage::where('id',$id)->first();
        $productId = $storeProduct->product_id;
        $product = Product::find($productId); //dd($product);
        $price = $product->price;
        $qty = $request->quantity;
        //$taxRate = $setting->tax_rate;
        $shipCharge = $setting->ship_charge;
        //$tax = $price * $taxRate / 100;
        $subTotal = $price * $qty;
        $total = $subTotal + $shipCharge;

        $discount = $total * $storeProduct->percentage /100;
        
        $data['product_id'] = $productId;
        $data['product_name'] = $product->name;
        $data['price'] = $price;
        $data['qty'] = $qty;
        $data['description'] = $product->description;
        $data['image'] = $product->image;
        //$data['tax'] = $tax;
        //$data['tax_rate'] = $taxRate;
        $data['ship_charge'] = $shipCharge;
        $data['discount'] = $discount;
        $data['discount_percentage'] = $storeProduct->discount_percentage;
        $data['subtotal'] = $subTotal;
        $data['total'] = $total;
        $data['net_amount'] = $total - $discount;
        //dd($data);
        CartStorage::where('id',$id)->update($data);
        Toastr::success('Cart Update', 'Success', ["positionClass" => "toast-bottom-right"]);
        return back();
    }

    public function putCoupan(Request $request){

        $id = Auth::id();
        $checkCoupan = DiscountCoupan::where('code',$request->coupon_code)->first();
        if($checkCoupan){
            if($checkCoupan->code == "FREESHIP"){
                $storeProduct = CartStorage::where('user_id',$id)->first(); //dd($storeProduct);
                $discount = 50;
                $data['discount'] = $discount;
                $data['discount_percentage'] = 0;
                $data['coupan_code'] = $checkCoupan->code;
                $data['net_amount'] = $storeProduct->total - $discount;
                //dd($data);
                $storeProduct->update($data);
                Toastr::success('Coupan apply', 'Success', ["positionClass" => "toast-bottom-right"]);
                return back();
                }else{
                Toastr::error('Coupan not exists', 'Error', ["positionClass" => "toast-bottom-right"]);
                return back();
                }
        $storeProduct = CartStorage::where('user_id',$id)->first();
        $discount = $storeProduct->total * $checkCoupan->percentage /100;
        $data['discount'] = $discount;
        $data['discount_percentage'] = $checkCoupan->percentage;
        $data['coupan_code'] = $checkCoupan->code;
        $data['net_amount'] = $storeProduct->total - $discount;
        $storeProduct->update($data);
        Toastr::success('Coupan apply', 'Success', ["positionClass" => "toast-bottom-right"]);
        return back();
        }else{
        Toastr::error('Coupan not exists', 'Error', ["positionClass" => "toast-bottom-right"]);
        return back();
        }
    }

    public function clearCart()
    {
        $userId = Auth::id();
        CartStorage::where('user_id',$userId)->delete();
        Toastr::success('Clear Cart', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CartStorage  $cartStorage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        CartStorage::where('id',$id)->where('user_id',$userId)->delete();
        Toastr::success('Item Remove', 'Success', ["positionClass" => "toast-bottom-right"]);
        return back();
    }
}
