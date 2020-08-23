<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Validator;
use Redirect;
use Toastr;
use Carbon\Carbon;
use App\Page;
use Auth;


class PageController extends Controller
{
    public function index()
    {if(Auth::check()){
            if(Auth::user()->role == "admin"){
        $page = Page::orderBy('created_at','asc')->paginate(10);
        return view('Admin.Page.Show',['page' =>$page]);
        }
    }else{
        return redirect()->to('/login');
    }
    }

    public function create()
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        return view('Admin.Page.Add');
        }
    }else{
        return redirect()->to('/login');
    }
    }

    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'text' => 'required',
            'slug' => 'required',
        ]);
        if(!$validate){
                        Redirect::back()->withInput();
                          }
        $page = Page::create($request->all());
        Toastr::success('Page Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/page/show');
    }

    public function edit($id)
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $page = Page::find($id);
        return view('Admin.Page.Edit',['page' =>$page]);
        }
    }else{
        return redirect()->to('/login');
    }
    }

    public function update(Request $request, $id)
    {
        $page = Page::find($id);

        $page->update($request->all());
        Toastr::success('Page updated', 'Success', ["positionClass" => "toast-bottom-right"]);

      return redirect()->to('/page/show');
    }

    public function destroy($id)
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $page = Page::find($id);
        $page->delete();
        Toastr::success('Page deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/page/show');
        }
    }else{
        return redirect()->to('/login');
    }
    }
}
