<?php

namespace App\Http\Controllers;

use App\ChatPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Toastr;
use App\Order;
use App\Contact;
use Auth;

class ChatPlanController extends Controller
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
        $plan = ChatPlan::orderBy('created_at','desc')->paginate(5);
        return view('Admin.Plan.Show',compact('getOrders','contacts'),['plan' =>$plan]);
        }
    }else{
        return redirect()->to('/login');
    }
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
        return view('Admin.Plan.Add',compact('getOrders','contacts'));
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
        $plan = ChatPlan::create($request->all());
        Toastr::success('Plan Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/plans');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChatPlan  $chatPlan
     * @return \Illuminate\Http\Response
     */
    public function show(ChatPlan $chatPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChatPlan  $chatPlan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        $plan = ChatPlan::find($id);
        return view('Admin.Plan.Edit',compact('getOrders','contacts'),['plan' =>$plan]);
        }
    }else{
        return redirect()->to('/login');
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChatPlan  $chatPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $plan = ChatPlan::find($id);

        $plan->update($request->all());
        Toastr::success('Plan updated', 'Success', ["positionClass" => "toast-bottom-right"]);

      return redirect()->to('/plans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChatPlan  $chatPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $plan = ChatPlan::find($id);
        $plan->delete();
        Toastr::success('Plan deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/plans');
    }
    }else{
        return redirect()->to('/login');
    }
    }
}
