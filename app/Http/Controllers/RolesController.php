<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{

    // public function index(Request $request)
    // {
    //     $data = Roles::get();

    //     return $data;
    // }

    // public function store(Request $request)
    // {
    //     $data = new Roles;
    //     $data->admin = $request->admin;
    //     $data->super_admin = $request->super_admin;
    //     $data->save();

    //     return $data;
    // }

    // public function update(Request $request)
    // {
    //     $data = Roles::find($request->role_id);
    //     $data->admin = $request->admin;
    //     $data->super_admin = $request->super_admin;
    //     $data->save();

    //     return $data;
    // }

    // public function delete(Request $request)
    // {
    //     Roles::whereId($request->role_id)->delete();
    //     return "Roles deleted.";
    // }

    
    public function index(Request $request)
    {
        try {
            $is_active = $request->is_active ?? null;
            $data = Role::orderBy("id", "asc");
            if (!empty($is_active)) {
                $data = $data->where("is_active", $is_active);
            }
            $data = $data->get();
            return apiReqponse($data, true, DATA_FATCHED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function store(Request $request)
    {

        $validation = Validator::make(
            $request->all(),
            [
                // 'name' => ['required'],
                // 'role_id' => ['required'],
                // 'email' => ['required', Rule::unique('users')->whereNull('deleted_at')],
                // 'password' => ['required']
            ]
        );

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {

            if ($request->role_id == 1 && $request->role_id == 2) {
                return apiReqponse('', false, ADMIN_ROLE, BAD_REQUEST);
            }
            $userObj = new Role;
            $userObj->name = $request->name;
            $userObj->is_active = $request->is_active;
            $userObj->save();
            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            // 'name' => ['required', 'unique:users,name,' . $request->discount_id],
            // 'is_active' => ['required'],
            // 'user_id' => ['required', 'exists:users,id']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Role::find($request->role_id);
            $obj->name = $request->name;
            $obj->is_active = $request->is_active;
            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        try {
            Role::whereId($request->role_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function show(Request $request)
    {
        $validation = Validator::make($request->all(), [
   
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Role::find($request->role_id);
        
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
