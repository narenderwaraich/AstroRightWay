<?php

namespace App\Http\Controllers;

use App\Gellery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Toastr;
use App\CartStorage;
use Auth;
use Response;
use App\Order;
use App\Contact;
use App\BanerSlide;

class GelleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        $gallery = Gellery::orderBy('created_at','desc')->paginate(10);
        return view('Admin.Gellery.Show',compact('getOrders','contacts'),['gallery' =>$gallery]);
    }
    
    public function galleryPage(){
        $banner = BanerSlide::where('page_name','=','gallery')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        $gallery = Gellery::orderBy('created_at','desc')->paginate(5);
        if(Auth::check()){
            $userId = Auth::id();
            $cartCollection = CartStorage::where('user_id',$userId)->get();
            $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
            return view('blog',compact('title','description'),['banner' =>$banner, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal,'gallery' =>$gallery]);
        }else{
            return view('blog',compact('title','description'),['banner' =>$banner, 'gallery' =>$gallery]);
        }
        
    }

    public function getData()
    {
        $data = Gellery::orderBy('created_at','desc')->get();
      return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.Gellery.Add',compact('getOrders','contacts'));
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
            'title' => 'required',
        ]);
        if(!$validate){
            Redirect::back()->withInput();
        }
        if($request->file('uploadFile')){
            foreach ($request->file('uploadFile') as $key => $value) {

                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('images/gellery'), $imageName);
                $data['image'] =$imageName;
            }
        }
        $data['title'] = $request->title;
        $data['auth'] = $request->auth;
        $data['url'] = $request->url;
        $data['description'] = $request->description;
        $gellery = Gellery::create($data);

        Toastr::success('Image Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/gallery/show');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gellery  $Gellery
     * @return \Illuminate\Http\Response
     */
    public function show(Gellery $Gellery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gellery  $Gellery
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        $gallery = Gellery::find($id);
        return view('Admin.Gellery.Edit',compact('getOrders','contacts'),['gallery' =>$gallery]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gellery  $Gellery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $this->validate($request, [
            'title' => 'required',

        ]);
        if(!$validate){
            Redirect::back()->withInput();
        }
        $gallery = Gellery::find($id);
        if($request->file('uploadFile')){
            foreach ($request->file('uploadFile') as $key => $value) {

                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('images/gellery'), $imageName);
                $data['image'] = $imageName;
            }
            $data['title'] = $request->title;
            $data['auth'] = $request->auth;
            $data['url'] = $request->url;
            $data['description'] = $request->description;
            $gallery->update($data);
            Toastr::success('Image updated', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/gallery/show');
        }else{
            $gallery->update($request->all());
            Toastr::success('Image updated', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/gallery/show');
        }
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gellery  $Gellery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gellery::find($id);
        $gallery->delete();
        Toastr::success('Image Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/gallery/show');
    }
}
