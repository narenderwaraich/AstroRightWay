<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Auth;
use Toastr;
use App\Role;
use App\PermissionRole;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Permission::orderBy('created_at','desc')->paginate(5);
      return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $permission = Permission::create($request->all());
        return response()->json($permission);
    }

    public function getData()
    {
        $data = Permission::orderBy('created_at','desc')->get();
        $loop =0;
        foreach ($data as $key => $value) {
            $options[$key] = [
                 "id" => $value->id, "name" => $value->title 
              ];
            $loop++;
        }
        //dd($options);

      return response()->json($options);
    }

    public function getUpdateData()
    {
        $data = Permission::orderBy('created_at','desc')->get();
        return response()->json($data);
    }


    public function set(Request $request)
    {
        $items = $request->all();
        $roleId = $items['role'];
        $loop = 0;
        foreach ($items['permission'] as $key => $item){
            $user[$loop][$key] = DB::table("permission_role")->insert(['role_id' => $roleId, 'permission_id' => $item['id']]); 
            $loop++;
        }
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = PermissionRole::orderBy('id','desc')->paginate(10); 
        // $role = Role::find(1);
        // $data = $role->permission;
        //dd($data);
        foreach ($data as $perData) {
            $perData->role = Role::where('id',$perData->role_id)->first()->title;
            $perData->permission = Permission::where('id',$perData->permission_id)->first()->title;
        }

         return response()->json($data);
    }

    public function action()
    {
        
        $data = PermissionRole::orderBy('id','desc')->paginate(10); 
        // $role = Role::find(1);
        // $data = $role->permission;
        //dd($data);
        foreach ($data as $perData) {
            $perData->role = Role::where('id',$perData->role_id)->first()->title;
            $perData->permission = Permission::where('id',$perData->permission_id)->first()->title;
        }

         return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        return response()->json($permission);
    }

    public function editSet($id)
    {
        $permission = PermissionRole::find($id);
        // $role = Role::find($id);
        // $permission = $role->permission;
        return response()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);

        $permission->update($request->all());

      return response()->json('successfully updated');
    }

    public function updateSet(Request $request, $id)
    {
        
        $permission = PermissionRole::find($id);

        $permission->update($request->all());
        print_r($permission); exit();


      return response()->json('successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);

        $permission->delete();
      return response()->json('successfully updated');
    }

    public function destroySet($id)
    {
        $permission = PermissionRole::find($id);

        $permission->delete();
      return response()->json('successfully updated');
    }
}
