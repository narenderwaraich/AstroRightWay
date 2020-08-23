<?php

namespace App\Http\Controllers;

use App\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Toastr;
use App\Order;
use App\Contact;
use App\Product;
use Auth;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        $productType = ProductType::orderBy('created_at','desc')->paginate(10);
        return view('Admin.ProductsType.Show',compact('getOrders','contacts'),['productType' =>$productType]);
        }
    }else{
        return redirect()->to('/login');
    }
    }

    public function getData()
    {
        $data = ProductType::orderBy('created_at','desc')->get();
      return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.ProductsType.Add',compact('getOrders','contacts'));
        }
    }else{
        return redirect()->to('/login');
    }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'name' => 'required',
        ]);
        if(!$validate){
                            Redirect::back()->withInput();
                          }
        $productType = ProductType::create($request->all());
        Toastr::success('ProductsType Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/product-type');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductType  $ProductType
     * @return \Illuminate\Http\Response
     */
    public function show(ProductType $ProductType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductType  $ProductType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        $productType = ProductType::find($id);
        return view('Admin.ProductsType.Edit',compact('getOrders','contacts'),['productType' =>$productType]);
        }
    }else{
        return redirect()->to('/login');
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductType  $ProductType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $productType = ProductType::find($id);

        $productType->update($request->all());

      Toastr::success('ProductsType updated', 'Success', ["positionClass" => "toast-bottom-right"]);

      return redirect()->to('/product-type');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductType  $ProductType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $productType = ProductType::find($id);

        $productType->delete();
        Toastr::success('ProductType deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/product-type');
        }
    }else{
        return redirect()->to('/login');
    }
    }
}
