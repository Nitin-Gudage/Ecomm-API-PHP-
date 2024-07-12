<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RolePermission;



use Exception;
use Illuminate\Support\Facades\Validator;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            
            $data = RolePermission::with(['role','permission'])->orderBy("id", "desc");
            if ($request->is_active !== null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('rolepermission_id')) {
                $data = $data->where("id", $request->rolepermission_id);
            }
           
            // if ($request->has('orderstatus_id')) {
            //     $data = $data->whereHas('orderstatus', function ($query) use ($request) {
            //         $query->where('id', $request->orderstatus_id);
            //     });
            
            
            $data = $data->get();
            return apiReqponse($data, true, DATA_FATCHED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
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
        $validation = Validator::make(
            $request->all(),
            [
                'role_id' => ['required'],
                'permission_id' => ['required'],
                'is_active' => ['required'],
                
            ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $new_arr = [];
            foreach( $request->permission_id as $role_per){
            $userObj = new RolePermission;
            $userObj->role_id = $request->role_id;
            $userObj->permission_id = $role_per;
            $userObj->is_active = $request->is_active;
            $userObj->save();
            $new_arr[] = $userObj;


            }
            return apiReqponse($new_arr, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(),
        [ 
            'role_id' => ['required'],
        'permission_id' => ['required'],
        'is_active' => ['required'],
       ]);

       if ($validation->fails()) {
           $error = $validation->errors()->first();
           return apiReqponse('', false, $error, BAD_REQUEST);
       }
       try {
           $obj = RolePermission::find($request->rolepermission_id);
           $obj->role_id = $request->role_id;
           $obj->permission_id = $request->permission_id;
            $obj->is_active = $request->is_active;
        
            $obj->save();
           return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
       } catch (Exception $e) {
           return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            RolePermission::whereId($request->rolepermission_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
