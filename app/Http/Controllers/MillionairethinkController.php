<?php

namespace App\Http\Controllers;

use App\Millionairethink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;
use Toastr;
use Validator;
use Mail;
use Auth;
use App\BanerSlide;
use App\Mail\MillionairethinkMail;

class MillionairethinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            if(Auth::id() ==1 || Auth::id() == 1){
                $getQuery = Millionairethink::orderBy('created_at','desc')->paginate(10); //dd($getQuery);
                return view('millionairethink-list',['getQuery' =>$getQuery]);
            }
        }else{
           return redirect('/login'); 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banner = BanerSlide::where('page_name','=','millionaire-think')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        return view('millionairethink',compact('title','description'),['banner' =>$banner]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validate(request(),[
            'name'=>'required|string|max:50',
            'email'=>'required|string|email|max:255',
            'phone'=>'required|string|max:10|min:10',
          ]);
          if(!$validate){
            Redirect::back()->withInput();
          }
          $data = request(['name','message','email','phone']);
          $query = Millionairethink::create($data);
          $email = "gurjantflp275@gmail.com";
          Mail::to($email)->send(new MillionairethinkMail($query));
          Toastr::success('Query Sent', 'Success', ["positionClass" => "toast-top-right"]);
          return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Millionairethink  $millionairethink
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $getQuery = Millionairethink::orderBy('created_at','desc')->paginate(10); //dd($getQuery);
        return view('Admin.millionairethink',['getQuery' =>$getQuery]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Millionairethink  $millionairethink
     * @return \Illuminate\Http\Response
     */
    public function edit(Millionairethink $millionairethink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Millionairethink  $millionairethink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Millionairethink $millionairethink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Millionairethink  $millionairethink
     * @return \Illuminate\Http\Response
     */
    public function destroy(Millionairethink $millionairethink)
    {
        //
    }
}
