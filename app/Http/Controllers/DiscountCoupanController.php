<?php

namespace App\Http\Controllers;

use App\DiscountCoupan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Toastr;
use App\Order;
use App\Contact;
use App\Product;
use Auth;

class DiscountCoupanController extends Controller
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
        $discount = DiscountCoupan::orderBy('created_at','desc')->paginate(10);
        return view('Admin.Coupan.Show',compact('getOrders','contacts'),['discount' =>$discount]);
        }
    }else{
        return redirect()->to('/login');
    }
    }

    public function getData()
    {
        $data = DiscountCoupan::orderBy('created_at','desc')->get();
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
        return view('Admin.Coupan.Add',compact('getOrders','contacts'));
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
        $discount = DiscountCoupan::create($request->all());
        Toastr::success('DiscountCoupan Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/discounts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DiscountCoupan  $DiscountCoupan
     * @return \Illuminate\Http\Response
     */
    public function show(DiscountCoupan $DiscountCoupan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DiscountCoupan  $DiscountCoupan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        $discount = DiscountCoupan::find($id);
        return view('Admin.Coupan.Edit',compact('getOrders','contacts'),['discount' =>$discount]);
        }
    }else{
        return redirect()->to('/login');
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DiscountCoupan  $DiscountCoupan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $discount = DiscountCoupan::find($id);

        $discount->update($request->all());
        Toastr::success('DiscountCoupan updated', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/discounts');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DiscountCoupan  $DiscountCoupan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $discount = DiscountCoupan::find($id);
        $discount->delete();
        Toastr::success('DiscountCoupan deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/discounts');
        }
    }else{
        return redirect()->to('/login');
    }
    }
}
