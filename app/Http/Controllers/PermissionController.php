<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = Permission::with('permissions', 'permissions.permissions');
            if (isset($request->is_active) && !empty($request->is_active)) {
                $data = $data->where('is_active', $request->is_active);
            }


            if (isset($request->role_id) && !empty($request->role_id)) {
                $data = $data->with('permissions' , function($query){
                    $query->where('is_active', true);
                })->whereNull('parent_id')->get()->toArray();
                $role = Role::whereId($request->role_id)->first();
                $rolePermisions = $role->permissions->pluck('permission_id')->toArray() ?? [];
                foreach ($data as $key => $per) {
                    if (in_array($per['id'], $rolePermisions)) {
                        $data[$key]['is_checked'] = true;
                    }
                    foreach ($per['permissions'] ?? [] as $key1 => $p) {
                        if (in_array($p['id'], $rolePermisions)) {
                            $data[$key]['permissions'][$key1]['is_checked'] = true;
                        }
                        foreach ($p['permissions'] ?? [] as $key2 => $pr) {
                            if (in_array($pr['id'], $rolePermisions)) {
                                $data[$key]['permissions'][$key1]['permissions'][$key2]['is_checked'] = true;
                            }
                        }
                    }
                }
                $resData['role'] = $role;
            } else {
                $data = $data->get()->toArray();
            }
            $resData['permissions'] = $data;

            return apiReqponse($resData, true, DATA_FATCHED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'unique:permissions'],
            'is_active' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $data = $request->all();
            $id = Permission::insertGetId($data);
            $resData = Permission::find($id);
            return apiReqponse($resData, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'permission_id' => ['required', 'exists:permissions,id']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $resData = Permission::find($request->permission_id);
            $resData->is_active = $resData->is_active == 1 ? 0 : 1;
            $resData->save();
            if(empty($resData->parent_id)){
                Permission::where('parent_id',$request->permission_id)->update(['is_active' =>  $resData->is_active == 1 ? 1 : 0]);
            }
            return apiReqponse($resData, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'permission_id' => ['required', 'exists:permissions,id']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            Permission::whereId($request->permission_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
