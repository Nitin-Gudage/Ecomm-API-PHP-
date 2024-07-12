<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RolePermission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = Role::orderBy('name', 'asc');
            if (isset($request->type)) {
                $data = $data->whereNotIn('id', [1, 2, 5]);
            }
            $data = $data->get();
            return apiReqponse($data, true, DATA_FATCHED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'unique:roles'],
            'is_active' => ['required']
        ]);
        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $data = $request->all();
            $role_id = Role::insertGetId($data);
            $resData = Role::whereId($role_id)->first();
            return apiReqponse($resData, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function assignPermission(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'role_id' => ['required', 'exists:roles,id'],
            'permission_id' => ['required']
        ]);
        if ($validation->fails()) {

            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $permissions = $request->permission_id ?? [];
            RolePermission::where('role_id', $request->role_id)->delete();
            foreach ($permissions as $permission_id) {
                $rp = new RolePermission;
                $rp->role_id = $request->role_id;
                $rp->permission_id = $permission_id;
                $rp->save();
            }
            return apiReqponse('', true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'unique:roles,name,' . $request->role_id],
            'is_active' => ['required'],
            'role_id' => ['required', 'exists:roles,id']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $data = $request->all();
            $role_id = $request->role_id;
            unset($data['role_id']);
            Role::whereId($role_id)->update($data);
            $resData = Role::with('permissions:id,role_id,permission_id')->whereId($role_id)->first();
            return apiReqponse($resData, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'role_id' => ['required', 'exists:roles,id']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            Role::whereId($request->role_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
