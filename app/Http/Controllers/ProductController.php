<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\ProductImage;
use Storage;
use File;
use App\Category;
use App\ProductType;
use App\Review;
use Illuminate\Support\Facades\DB;
use Auth;
use Toastr;
use Validator;
use App\CartStorage;
use Carbon\Carbon;
use Redirect;
use Response;
use App\User;
use App\Order;
use App\Contact;
use App\BanerSlide;

class ProductController extends Controller
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
        $product = Product::orderBy('created_at','desc')->paginate(5);
        foreach ($product as $productData) {
            $productData->category = Category::where('id',$productData->category_id)->first()->name;
            $productData->type = ProductType::where('id',$productData->product_types_id)->first()->name;         

        }
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
      return view('Admin.Products.Show',compact('getOrders','contacts'),['product' =>$product]);
      }
    }else{
        return redirect()->to('/login');
    }
    }

    public function getData()
    {
        $data = Product::orderBy('created_at','desc')->get();
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
        $categories = Category::all();
        $productTypes =  ProductType::all();
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.Products.Add',compact('getOrders','contacts'),['categories' =>$categories, 'productTypes' =>$productTypes]);
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
      //return $request;
      $validate = $this->validate(request(),[
          'name'=>'required|string|max:50',
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
            if(!$validate){ 
                 Redirect::back()->withInput();
            }
        $data = request(['name','price','original_price','qty','category_id','product_types_id','description']);
        $file = $request->image;
        $filename = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('images/products'), $filename);
        $data['image'] = $filename;
    if($request->file('uploadFile')){
        foreach ($request->file('uploadFile') as $key => $value) {

            $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
            $value->move(public_path('images/products'), $imageName);
            $dataImg[] =$imageName;
        }
        //dd($dataImg);
        $data['image1'] = (!empty($dataImg[0])) ? $dataImg[0] : "";
        $data['image2'] = (!empty($dataImg[1])) ? $dataImg[1] : "";
        $data['image3'] = (!empty($dataImg[2])) ? $dataImg[2] : "";
        $data['image4'] = (!empty($dataImg[3])) ? $dataImg[3] : "";
    }
        
        //dd($data);
        $product = Product::create($data);
        Toastr::success('Product Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/products');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $Product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(Auth::check()){
    if(Auth::user()->role == "administrator" || Auth::user()->role == "admin"){
        $product = Product::find($id);
        $categories = Category::all();
        $productTypes =  ProductType::all();
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.Products.Edit',compact('getOrders','contacts'),['product' =>$product, 'categories' =>$categories, 'productTypes' =>$productTypes]);
        }
    }else{
        return redirect()->to('/login');
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return $request;
        $validate = $this->validate(request(),[
          'name'=>'required|string|max:50',
          'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
            if(!$validate){ 
                 Redirect::back()->withInput();
            }
        $product = Product::find($id);
        $data = request(['name','price','original_price','qty','category_id','product_types_id','description']);
        if($request->image){
            $file = $request->image;
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('public/images/products'), $filename);
            $data['image'] = $filename;
        }
        if($request->image1){
            $file = $request->image1;
            $filename1 = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('public/images/products'), $filename1);
            $data['image1'] = $filename1;
        }
        if($request->image2){
            $file = $request->image2;
            $filename2 = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('public/images/products'), $filename2);
            $data['image2'] = $filename2;
        }
        if($request->image3){
            $file = $request->image3;
            $filename3 = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('public/images/products'), $filename3);
            $data['image3'] = $filename3;
        }
        if($request->image4){
            $file = $request->image4;
            $filename4 = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('public/images/products'), $filename4);
            $data['image4'] = $filename4;
        }
        //dd($data);
        $product->update($data); //dd($product);
        
        Toastr::success('Product Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/products');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if(Auth::check()){
    if(Auth::user()->role == "administrator" || Auth::user()->role == "admin"){
        DB::table("products")->where('id',$id)->delete(); 
        Toastr::success('Product Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
         return redirect()->back();
         }
    }else{
        return redirect()->to('/login');
    }
    }

       public function productStock(){
      if(Auth::check()){
        if(Auth::user()->role == "administrator" || Auth::user()->role == "admin"){
            $products = Product::orderBy('created_at','desc')->paginate(5);
            //dd($products);
            $i = 1;
            foreach ($products as $productData) {
                $productData->category = Category::where('id',$productData->category_id)->first()->name;
                $productData->type = ProductType::where('id',$productData->product_types_id)->first()->name;
                $productData->no = $i++ ;
            }
            $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
          return view('Admin.Products.Stock',compact('getOrders','contacts'),['products' =>$products]);
        }
      }
    }
    
   public function productDetails($id){
         $banner = BanerSlide::where('page_name','=','product-detail')->first(); //dd($banner);
         if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
          }
         $productData = Product::where('id',$id)->first(); //dd($productData);
         $productImage = ProductImage::where('product_id',$id)->get(); //dd($productImage);
         $products = Product::all();
         $data = Review::where('product_id',$id)->get();
        $reviews = json_decode($data,true); //dd($reviews);
        $max = 0;
        $count = count($data); //dd($count);
        foreach ($reviews as $key => $review) {
           $max = $max + $review['rating'];
        }
        if($max !=0){
          $totalReview = $max/$count; //dd($totalReview);
        }else{
          $totalReview = 0;
        }
        $rating = number_format($totalReview, 1);  //dd($rating);

        /// product total comment
        $comments = Review::where('product_id',$id)->orderBy('created_at','desc')->paginate(2);
        foreach ($comments as $key => $comment) {
            $comment->userName = User::where('id',$comment->user_id)->first()->name;
        }
        if(Auth::check()){
            $userId = Auth::id();
            $cartCollection = CartStorage::where('user_id',$userId)->get();
        $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
            return view('product-detail',compact('title','description'),['banner' =>$banner,'productData' =>$productData, 'productImage' =>$productImage, 'products' =>$products, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal, 'rating' => $rating, 'count' =>$count, 'comments' => $comments]);
        }else{
            return view('product-detail',compact('title','description'),['banner' =>$banner,'productData' =>$productData, 'productImage' =>$productImage, 'products' =>$products, 'rating' =>$rating, 'count' =>$count, 'comments' => $comments]);
        }
        
    }



public function productView(){
      $banner = BanerSlide::where('page_name','=','product')->first(); //dd($banner);
      if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
      $category = Category::all();
      $products = Product::latest()->paginate(9);
        if(Auth::check()){  
            $userId = Auth::id();
            $cartCollection = CartStorage::where('user_id',$userId)->get();
        $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
            return view('product',compact('title','description'),['banner' =>$banner, 'products' =>$products, 'category' =>$category, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal])->with('i', (request()->input('page', 1) - 1) * 5);
        }else{
            return view('product',compact('title','description'),['banner' =>$banner, 'products' =>$products, 'category' =>$category])->with('i', (request()->input('page', 1) - 1) * 5);
        }
        
    }

    public function categoryView($name){
      $banner = BanerSlide::where('page_name','=','product-category')->first(); //dd($banner);
      if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
      $categoryName = Category::where('name',$name)->first();
      $id = $categoryName->id;
      $products = Product::where('category_id',$id)->latest()->paginate(9);
      $category = Category::all();
      if(Auth::check()){   
        $userId = Auth::id();
        $cartCollection = CartStorage::where('user_id',$userId)->get();
        $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
        return view('product-category',compact('title','description'),['banner' =>$banner, 'products' =>$products, 'category' =>$category, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal])->with('i', (request()->input('page', 1) - 1) * 5);
      }else{
        return view('product-category',compact('title','description'),['banner' =>$banner, 'products' =>$products, 'category' =>$category])->with('i', (request()->input('page', 1) - 1) * 5);
      }
      
    }

}
