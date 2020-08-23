<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Product;
use App\Category;
use App\ProductType;
use Carbon\Carbon;
use Redirect;
use Response;
use App\BanerSlide;

class SearchController extends Controller
{
    public function SearchData(Request $request){
        $banner = BanerSlide::where('page_name','=','product')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        $q = Input::get ( 'search-product' ); //dd($q);
        $category = Category::all();
        $products = Product::where('name', 'like', '%'.$q.'%')->orderBy('created_at', 'desc')->paginate(10)->setPath ( '' );
                    $pagination = $products->appends ( array (
                    'q' => Input::get ( 'search-product' )
                    ) );
        if(Auth::check()){  
            $userId = Auth::id();
            $cartCollection = CartStorage::where('user_id',$userId)->get();
            $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
            if (count ( $products ) > 0){ 
            $total_row = $products->count();
            return view ('product',compact('total_row','title','description'),['banner' =>$banner, 'products' =>$products, 'category' =>$category, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal])->withProducts( $products )->withQuery ( $q )->withMessage ($total_row.' '. 'Showing results');
            }else{
                return view ('product',compact('title','description'),['banner' =>$banner, 'category' =>$category, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal])->withMessage ( 'Product not found match Your search !' );
            }       
        }else{
            if (count ( $products ) > 0){ 
            $total_row = $products->count();
            return view ('product',compact('total_row','title','description'),['banner' =>$banner, 'products' =>$products, 'category' =>$category])->withProducts( $products )->withQuery ( $q )->withMessage ($total_row.' '. 'Showing results');
            }else{
                return view ('product',compact('title','description'),['banner' =>$banner, 'category' =>$category])->withMessage ( 'Product not found match Your search !' );
            }       
        }
    }

}
