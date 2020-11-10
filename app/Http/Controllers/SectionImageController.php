<?php

namespace App\Http\Controllers;

use App\SectionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Auth;
use Toastr;
use Redirect;
use App\Page;
use App\User;

class SectionImageController extends Controller
{
   
    public function pageIndex()
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $pageSetup = SectionImage::orderBy('created_at','desc')->paginate(8);
        return view('Admin.SectionImage.Show',['pageSetup' =>$pageSetup]);
      }
    }else{
        return redirect()->to('/login');
    }
    }
    
    public function pageCreate()
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $pages = Page::All();
        return view('Admin.SectionImage.Add',['pages' => $pages]);
      }
    }else{
        return redirect()->to('/login');
    }
    }

    public function pageStore(Request $request)
    {
        $validate = $this->validate($request, [
            'page_name' => 'required',
        ]);
        if(!$validate){
            Redirect::back()->withInput();
        }
        $data = request(['section','page_name','section_heading','section_sub_heading','section_content']);
        if($request->file('uploadFile')){
            foreach ($request->file('uploadFile') as $key => $value) {

                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('images/bg'), $imageName);
                $data['bg_img'] =$imageName;
            }
        }
        $pageSetup = SectionImage::create($data);
        Toastr::success('Page Section Added', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/section-image/show'); 
        
    }
    public function pageEdit($id)
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $pageSetup = SectionImage::find($id);
        $pages = Page::All();
        return view('Admin.SectionImage.Edit',['pageSetup' =>$pageSetup, 'pages' => $pages]);
      }
}else{
    return redirect()->to('/login');
}
    }
    public function pageUpdate(Request $request, $id)
    {
        $validate = $this->validate($request, [
            'page_name' => 'required',

        ]);
        if(!$validate){
            Redirect::back()->withInput();
        }
        $pageSetup = SectionImage::find($id);
        $data = request(['section','page_name','section_heading','section_sub_heading','section_content']);
        if($request->file('uploadFile')){
            foreach ($request->file('uploadFile') as $key => $value) {

                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('images/bg'), $imageName);
                $data['bg_img'] = $imageName;
            }
            $pageSetup->update($data);
            Toastr::success('Page Section updated', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/section-image/show');
        }else{
            $pageSetup->update($request->all());
            Toastr::success('Page Section updated', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/section-image/show');
        }
 
    }
    public function pageDestroy($id)
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $pageSetup = SectionImage::find($id);
        $pageSetup->delete();
        Toastr::success('Page Section Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/section-image/show');
        }
}else{
    return redirect()->to('/login');
}
    }
}
