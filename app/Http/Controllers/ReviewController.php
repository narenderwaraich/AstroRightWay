<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Category;
use App\ProductType;
use Auth;
use Toastr;
use Carbon\Carbon;
use Redirect;
use Response;
use App\Order;
use App\OrderItem;
use App\BanerSlide;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $banner = BanerSlide::where('page_name','=','product-feedback')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        // $data = Review::where('product_id',$id)->get();
        // $reviews = json_decode($data,true); //dd($data);
        // $max = 0;
        // $count = count($data); //dd($count);
        // foreach ($reviews as $key => $review) {
        //    $max = $max + $review['rating'];
        // }
        // if ($count==0) {
        //     $totalReview = 0; //dd($totalReview);
        // }else{
        //     $totalReview = $max/$count; //dd($totalReview);
        // }
        
        // $rating = number_format($totalReview, 1);  //dd($rating);
        // $products = Product::find($id); //dd($products);

        $order = $id;
        return view('product-feedback',compact('title','description'),compact('order'),['banner' =>$banner]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $orderGet = Order::find($id);
        $orderItem = OrderItem::where('order_id',$id)->get();
        foreach ($orderItem as $item ) {
        $productId = $item->product_id;
        $data = request(['comment','rating']);
        $data['user_id'] = Auth::id();
        $data['product_id'] = $productId;
        $status['status'] = "Close";
        Order::where('id',$id)->update($status);
        Review::create($data);
        }
        Toastr::success('Comment Submit', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
