<?php

namespace App\Http\Controllers;

use App\Rashifal;
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

class RashifalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            $rashifal = Rashifal::orderBy('created_at','desc')->paginate(10);
            return view('Admin.TodayRashifal.Show',compact('getOrders','contacts'),['rashifal' =>$rashifal]);
        }else{
            return redirect()->to('/login');
        }
    }

    public function astrologerIndex()
    {
        if(Auth::check()){
            $rashifal = Rashifal::orderBy('created_at','desc')->paginate(10);
            return view('Astrologer.TodayRashifal.Show',['rashifal' =>$rashifal]);
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
            $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            return view('Admin.TodayRashifal.Add',compact('getOrders','contacts'));
        }else{
            return redirect()->to('/login');
        }
    }

    public function astrologerCreate()
    {
        if(Auth::check()){
            return view('Astrologer.TodayRashifal.Add');
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
        if(Auth::check()){
          if(Auth::user()->role == "astrologer"){
                $validate = $this->validate($request, [
                    'today_date' => 'required',
                ]);
                if(!$validate){
                                    Redirect::back()->withInput();
                                  }
                $Rashifal = Rashifal::create($request->all());
                Toastr::success('Rashifal Add', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/astrologer/today-rashi/show');
        }else{
            return redirect()->to('/today-rashi/show'); 
        }
     }else{
        return redirect()->to('/login');
    }
               
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rashifal  $Rashifal
     * @return \Illuminate\Http\Response
     */
    public function show(Rashifal $Rashifal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rashifal  $Rashifal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()){
            $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            $rashi = Rashifal::find($id);
            return view('Admin.TodayRashifal.Edit',compact('getOrders','contacts'),['rashi' =>$rashi]);
        }else{
            return redirect()->to('/login');
        }
    }

    public function astrologerEdit($id)
    {
        if(Auth::check()){
            $rashi = Rashifal::find($id);
            return view('Astrologer.TodayRashifal.Edit',['rashi' =>$rashi]);
        }else{
            return redirect()->to('/login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rashifal  $Rashifal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::check()){
          if(Auth::user()->role == "astrologer"){
                $rashi = Rashifal::find($id);

                $rashi->update($request->all());
                Toastr::success('Rashifal updated', 'Success', ["positionClass" => "toast-bottom-right"]);

              return redirect()->to('/astrologer/today-rashi/show');
        }else{
            return redirect()->to('/today-rashi/show'); 
        }
     }else{
        return redirect()->to('/login');
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rashifal  $Rashifal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check()){
            $rashi = Rashifal::find($id);
            $rashi->delete();
            Toastr::success('Rashifal deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/today-rashi/show');
        }else{
            return redirect()->to('/login');
        }
    }

    public function todayRashi(){
        $current = Carbon::now();
        $today = $current->format('l, d/m/Y'); //dd($today); 2020-04-19
        $banner = BanerSlide::where('page_name','=','rashi')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title .$today;
            $description = $banner->description .$today;
        }
        $todayDate = $current->format('Y-m-d'); //dd($todayDate);
        //$rashi = Rashifal::where('today_date','=',$todayDate)->orderBy('created_at','desc')->paginate(1); //dd($rashi);
        $rashi = Rashifal::orderBy('created_at','desc')->paginate(1); //dd($rashi);
        return view('rashi',compact('title','description','banner','rashi'));
    }

    public function rashifalWithName($name){
        $current = Carbon::now();
        $today = $current->format('l, d/m/Y'); //dd($today);
        $banner = BanerSlide::where('page_name','=','rashi-details')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title .$today;
            $description = $banner->description .$today;
        }
        $todayDate = $current->format('Y-m-d'); //dd($todayDate);
        //$rashi = Rashifal::where('today_date','=',$todayDate)->orderBy('created_at','desc')->paginate(1); //dd($rashi);
        $rashi = Rashifal::orderBy('created_at','desc')->paginate(1); //dd($rashi);
        $rashiDetail = Rashifal::select($name)->pluck($name); //dd($rashiDetail); //DB::table('rashifals')->select($name)->get(); //dd($rashiDetail);
        $rashiName = $name;
        return view('rashi-details',compact('title','description','banner','rashi','rashiName','rashiDetail'));
    }
}
