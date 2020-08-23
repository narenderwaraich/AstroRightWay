<?php

namespace App\Http\Controllers;

use App\Covid19;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Toastr;
use Carbon\Carbon;
use App\Order;
use App\Contact;
use App\BanerSlide;
use Auth;

class Covid19Controller extends Controller
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
        $covid19 = Covid19::orderBy('created_at','desc')->paginate(10);
        return view('Admin.Covid19.Show',compact('getOrders','contacts'),['covid19' =>$covid19]);
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
        return view('Admin.Covid19.Add',compact('getOrders','contacts'));
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
            'confirmed' => 'required',
            'recovered' => 'required',
            'deceased'  => 'required',
        ]);
        if(!$validate){
                            Redirect::back()->withInput();
                          }
        $data = request(['confirmed','recovered','deceased']);
        $data['active'] = $request->confirmed - $request->recovered - $request->deceased;
        $covid19 = Covid19::create($data);
        Toastr::success('Covid19 Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/covid19');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Covid19  $covid19
     * @return \Illuminate\Http\Response
     */
    public function show(Covid19 $covid19)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Covid19  $covid19
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        $covid19 = Covid19::find($id);
        return view('Admin.Covid19.Edit',compact('getOrders','contacts'),['covid19' =>$covid19]);
        }
    }else{
        return redirect()->to('/login');
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Covid19  $covid19
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $covid19 = Covid19::find($id);
        $data = request(['confirmed','recovered','deceased']);
        $data['active'] = $request->confirmed - $request->recovered - $request->deceased;
        $covid19->update($data);
        Toastr::success('Covid19 updated', 'Success', ["positionClass" => "toast-bottom-right"]);

        return redirect()->to('/covid19');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Covid19  $covid19
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $covid19 = Covid19::find($id);
        $covid19->delete();
        Toastr::success('Covid19 deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/covid19');
        }
    }else{
        return redirect()->to('/login');
    }
    }

    public function dailyUpdate(){
        $banner = BanerSlide::where('page_name','=','covid19')->first(); //dd($banner);
        $current = Carbon::now();
        $today = $current->format('l, d/m/Y'); //dd($today); 
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description. $today;
        }
        $yesterday = date("Y-m-d", strtotime( '-1 days' ) );
        $covid = Covid19::orderBy('created_at','desc')->paginate(1); //dd($covid);
        foreach ($covid as $covidData) {
            $covid19 = Covid19::whereDate('created_at', $yesterday )->first();

            $covidData->lastConfirmed = $covid19 ? $covid19->confirmed : 0;
            $covidData->lastRecovered = $covid19 ? $covid19->recovered : 0;
            $covidData->lastDeceased = $covid19 ? $covid19->deceased : 0;
            $covidData->lastActive = $covid19 ? $covid19->active : 0;
        }
        $covidAll = Covid19::all(); //dd($covidAll);
        $covid19 = Covid19::orderBy('created_at','desc')->paginate(10);
        return view('covid19',compact('title','description'),['banner' =>$banner, 'covid' =>$covid, 'covid19' =>$covid19, 'covidAll' =>$covidAll]);
    }
}
