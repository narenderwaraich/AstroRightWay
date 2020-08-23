<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Toastr;
use App\Order;
use App\Contact;
use App\Product;

class CategoryController extends Controller
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
        $category = Category::orderBy('created_at','desc')->paginate(10);
        return view('Admin.Category.Show',compact('getOrders','contacts'),['category' =>$category]);
    }

    public function getData()
    {
        $data = Category::orderBy('created_at','desc')->get();
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
        return view('Admin.Category.Add',compact('getOrders','contacts'));
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
        $category = Category::create($request->all());
        Toastr::success('category Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $Category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        $category = Category::find($id);
        return view('Admin.Category.Edit',compact('getOrders','contacts'),['category' =>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $category->update($request->all());
        Toastr::success('category updated', 'Success', ["positionClass" => "toast-bottom-right"]);

      return redirect()->to('/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        Toastr::success('Category deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/category');
    }
}
