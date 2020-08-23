<?php

namespace App\Http\Controllers;

use App\Youtube;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Toastr;
use App\Order;
use App\Contact;
use App\Product;
use App\CartStorage;
use Auth;
use Response;
use App\BanerSlide;

class YoutubeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            if(Auth::user()->role == "administrator" || Auth::user()->role == "admin"){
                $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
                $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
                $videos = Youtube::orderBy('created_at','desc')->paginate(10);
              return view('Admin.Videos.Show',compact('getOrders','contacts'),['videos' =>$videos]);
            }
        }else{
            return redirect()->to('/login');
        }
    }

    public function showAll()
    {
        $banner = BanerSlide::where('page_name','=','videos')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        $videos = Youtube::orderBy('created_at','desc')->paginate(10);
        if(Auth::check()){
            $userId = Auth::id();
            $cartCollection = CartStorage::where('user_id',$userId)->get();
            $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
            return view('videos',compact('title','description'),['banner' =>$banner, 'videos' =>$videos, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal]);
        }else{
            return view('videos',compact('title','description'),['banner' =>$banner, 'videos' =>$videos]);
        }
    }

    public function getData()
    {
        $data = Youtube::orderBy('created_at','desc')->get();
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
            if(Auth::user()->role == "administrator" || Auth::user()->role == "admin"){
                $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
                $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
                return view('Admin.Videos.Add',compact('getOrders','contacts'));
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
        $video = Youtube::create($request->all());
        Toastr::success('Video Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/videos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Youtube  $Youtube
     * @return \Illuminate\Http\Response
     */
    public function show(Youtube $Youtube)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Youtube  $Youtube
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()){
            if(Auth::user()->role == "administrator" || Auth::user()->role == "admin"){
                $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
                $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
                $video = Youtube::find($id);
                return view('Admin.Videos.Edit',compact('getOrders','contacts'),['video' =>$video]);
            }
        }else{
            return redirect()->to('/login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Youtube  $Youtube
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $video = Youtube::find($id);

        $video->update($request->all());

      Toastr::success('Video Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/videos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Youtube  $Youtube
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check()){
            if(Auth::user()->role == "administrator" || Auth::user()->role == "admin"){
                $video = Youtube::find($id);
                $video->delete();
                Toastr::success('Video deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->to('/videos');
          }
        }else{
            return redirect()->to('/login');
        }
    }
}
