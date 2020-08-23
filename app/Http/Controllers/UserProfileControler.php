<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserAddress;
use Auth;
use Toastr;
use Cart;
use DB;
use Hash;
use App\CartStorage;
use App\BanerSlide;

class UserProfileControler extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewProfile(){
        $banner = BanerSlide::where('page_name','=','profile')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        if(Auth::check()){
            $userId = Auth::id();
            $cartCollection = CartStorage::where('user_id',$userId)->get();
            $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
            $country_data =DB::table('countries')->select('id','name')->get();
            $state_data = DB::table("states")->select('id','name')->get();
            $city_data = DB::table("cities")->select('id','name')->get();
            $userAddress = UserAddress::where('user_id',$userId)->first();
            return view('user-profile',compact('title','description','country_data','state_data','city_data','userAddress'),['banner' =>$banner, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal]);
        }else{
            return redirect()->to('/login');
        }
        
    }

                    public function updateProfile(Request $request,$id){
                        $validate = $this->validate(request(),[
                            'name'=>'required|string|max:50',
                            'email' => 'required|email|unique:users,email,'.$request->id,
                            'avatar' => 'mimes:jpeg,bmp,png',
                            'phone_no'=>'string|max:10|min:10',
                          ]);
                          if(!$validate){
                            toster::error('this email already taken','Error',["positionClass" => "toast-bottom-right"]);
                            Redirect::back();
                          }

                             
                            $data = request(['name','email','phone_no','gender','date']);
                            if($request->avatar){
                              $imageName = time().'.'.request()->avatar->getClientOriginalExtension();

                              request()->avatar->move(public_path('images/user'), $imageName);
                              $data["avatar"] = $imageName;
                              }

                                $user=User::where('id',$id)->update($data);
                          Toastr::success('Account Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                          return redirect()->to('/user-profile');

                    }

                    public function accountSetting(){
                      if(Auth::check()){  
                            $userId = Auth::id();
                            $cartCollection = CartStorage::where('user_id',$userId)->get();
                          $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
                            return view('account-setting',['cartCollection' =>$cartCollection, 'subTotal' => $subTotal]);
                        }else{
                            return view('account-setting');
                        }
                    }

                    public function getChangePass(){
                      $banner = BanerSlide::where('page_name','=','change-password')->first(); //dd($banner);
                      if (isset($banner)) {
                          $title = $banner->title;
                          $description = $banner->description;
                      }
                      if(Auth::check()){  
                              $userId = Auth::id();
                              $cartCollection = CartStorage::where('user_id',$userId)->get();
                              $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
                              return view('change-password',['banner' =>$banner, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal]);
                          }else{
                              return view('change-password',['banner' =>$banner]);
                          }
                      }


                    public function updatePass(Request $request)
                      {
                      /////check validate
                            $validate = $this->validate(request(),[
                                'old_password' => 'required',
                                'password' => 'required|confirmed|string|min:6',
                            ]);
                             if(!$validate){ 
                              Redirect::back()->withInput();
                            }
                      $data = $request->all();
                      $user = User::find(auth()->user()->id);
                      if(!Hash::check($data['old_password'], $user->password)){
                        Toastr::error('The specified password does not match the database password', 'Error', ["positionClass" => "toast-top-right"]);
                                return back();
                      }else{
                          $password = $request->password;
                          $user->update(['password' => Hash::make($password)]);
                         Toastr::success('Password Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                                             return redirect()->to('/');
                      }
                    }

                    // public function getAddress(){
                    //     $country_data =DB::table('countries')->select('id','name')->get();
                    //     $state_data = DB::table("states")->select('id','name')->get();
                    //     $city_data = DB::table("cities")->select('id','name')->get();
                    //     if(Auth::check()){
                    //         $userId = Auth::id();
                    //         $cartCollection = CartStorage::where('user_id',$userId)->get();
                    //         $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
                    //         return view('user-address',compact('country_data','state_data','city_data'),['cartCollection' =>$cartCollection, 'subTotal' => $subTotal]);
                    //     }else{
                    //         return view('user-address',compact('country_data','state_data'));
                    //     }
                    //   }

                    public function storeAddress(Request $request,$id){
                        $validate = $this->validate(request(),[
                            'country'=>'required|string|max:50',
                            'state'=>'required|string|max:50',
                            'city'=>'required|string|max:50',
                            'zipcode'=>'required|string|max:50',
                            'address'=>'required|string|max:255',
                          ]);
                          if(!$validate){
                            Redirect::back()->withInput();
                          }

                            $data = request(['address', 'country','state','city','zipcode']);
                            $data['user_id'] = $id;
                                UserAddress::create($data);
                          Toastr::success('Address Add', 'Success', ["positionClass" => "toast-bottom-right"]);
                          return redirect()->to('/');
                    }

                    // public function getUpdateAddress(){
                    //     $id = Auth::id();
                    //     $userAddress = UserAddress::where('user_id',$id)->first(); 
                    //     if($userAddress){
                    //       $country_data =DB::table('countries')->select('id','name')->get();
                    //       $state_data = DB::table("states")->select('id','name')->get();
                    //      $city_data = DB::table("cities")->select('id','name')->get();
                    //         if(Auth::check()){
                    //           $userId = Auth::id();
                    //           $cartCollection = CartStorage::where('user_id',$userId)->get();
                    //           $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
                    //           return view('update-user-address',compact('country_data','state_data','city_data','userAddress'),['cartCollection' =>$cartCollection, 'subTotal' => $subTotal]);
                    //           }else{
                    //               return view('update-user-address',compact('country_data','state_data','userAddress'));
                    //           }
                    //     }else{
                    //       return redirect('/add-user-address');
                    //     }
                        
                    //   }

                    public function updateAddress(Request $request,$id){
                      $validate = $this->validate(request(),[
                            'country'=>'required|string|max:50',
                            'state'=>'required|string|max:50',
                            'city'=>'required|string|max:50',
                            'zipcode'=>'required|string|max:50',
                            'address'=>'required|string|max:255',
                          ]);
                          if(!$validate){
                            Redirect::back()->withInput();
                          }

                            $data = request(['address', 'country','state','city','zipcode']);
                                UserAddress::where('id',$id)->update($data);
                          Toastr::success('Address Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                          return redirect()->to('/');
                    }


}
