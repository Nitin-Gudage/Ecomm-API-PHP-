<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\MatchOldPassword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function changePassword(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'current_password' => ['required'],
            'new_password' => ['required'],
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        
        try {
            if (!Hash::check($request->current_password, auth()->user()->password)) {
                return apiReqponse('', false, PASSWORD_MISMATCHED, BAD_REQUEST);
            }
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password),
                'is_change' => 1
            ]);
            return apiReqponse('', true, PASSWORD_CHNAGED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function getRolePermissions()
    {
        $data =  getRolePermissions(auth()->user()->role_id);
        return apiReqponse($data, true, DATA_FATCHED, STATUS_OK);
    }

    public function index(Request $request)
    {

        try {
            $parent_id = $request->parent_id ?? null;
            $role_id = $request->role_id ?? null;
            $agent_id = $request->agent_id ?? null;
            $name = $request->name ??  null;
            $email = $request->email ?? null;
            $parent_name = $request->parent_name ?? null;
            $appData = User::with(['role:id,name'])->orderBy('name', 'asc');

            if (!empty($parent_id)) {
                $appData = $appData->where(['parent_id' => $parent_id, 'user_type' => 'employee']);
            }
            if ($request->has('user_id')){
                $appData = $appData->where("id", $request->user_id);
            }
          
          

            if (!empty($role_id)) {
                $appData = $appData->where('role_id', $role_id);
                if (!empty($parent_id)) {
                    $appData = $appData->where('parent_id', $parent_id);
                }

                if (empty($parent_id) && $role_id == 4) {
                    $appData = $appData->where('parent_id', 1);
                }
            }
         
            if (!empty($agent_id)) {
                $appData = $appData->where('agent_id', $agent_id);
            }
            if (!empty($parent_name)) {
                $appData = $appData->whereHas('parent', function ($query) use ($parent_name) {
                    $query->where('name', 'like', '%' . $parent_name . '%');
                });
            }
            if (!empty($name)) {
                $appData = $appData->where('name', 'like', '%' . $name . '%');
            }
            if (!empty($email)) {
                $appData = $appData->where('name', 'like', '%' . $email . '%');
            }

            $appData = $appData->get();
            return apiReqponse($appData, true, DATA_FATCHED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function details(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $userObj = User::whereId($request->user_id)->where('id', '!=', 1)->first();
            return apiReqponse($userObj, true, DATA_FATCHED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function store(Request $request)
    {

        $validation = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'role_id' => ['required'],
                'email' => ['required', Rule::unique('users')->whereNull('deleted_at')],
                'password' => ['required']
            ],
            [
                'prefix.unique' => "Location Code already exists. Please try again."
            ]
        );

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            if ($request->role_id == 1) {
                return apiReqponse('', false, ADMIN_ROLE, BAD_REQUEST);
            }
            $userObj = new User;
            $userObj->name = $request->name;
            $userObj->mobile = $request->mobile;
            if ($request->hasFile('profile')) {
        $profile = $request->file('profile');
        $fileName = "std-" . uniqid() . time() . '.' . $profile->getClientOriginalExtension();
        $path = $profile->move(public_path('storage/profile/'), $fileName);
        $url = asset('storage/profile/' . $fileName);
        $userObj->profile = $url; // ;
    }
            $userObj->email = $request->email;
            $userObj->password = Hash::make($request->password);
            $userObj->role_id = $request->role_id;
            $userObj->is_active = $request->is_active ?? true;
            $userObj->save();
            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }



    public function update(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'user_id' => ['required', 'exists:users,id'],
                'name' => ['required'],
                'prefix' => [Rule::unique('users')->ignore($request->user_id)->whereNull('deleted_at')],
                'email' => ['required', Rule::unique('users')->ignore($request->user_id)->whereNull('deleted_at')],
            ],
            [
                'prefix.unique' => "Location Code already exists. Please try again."
            ]
        );

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            if ($request->role_id == 1) {
                return apiReqponse('', false, ADMIN_ROLE, BAD_REQUEST);
            }
            $userObj = User::find($request->user_id);
            $userObj->name = $request->name;
            $userObj->mobile = $request->mobile;
            if ($request->hasFile('profile')) {
                $profile = $request->file('profile');
                $fileName = "std-" . uniqid() . time() . '.' . $profile->getClientOriginalExtension();
                $profile->storeAs('public/profile/', $fileName);
                $userObj->profile = $fileName;
            }
            $userObj->email = $request->email;
            if (!empty($request->password)) {
                $userObj->password = Hash::make($request->password);
            }
            $userObj->role_id = $request->role_id ?? $userObj->role_id;
            $userObj->is_active = $request->is_active ?? true;
            $userObj->save();

            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            if ($request->user_id != 1){
            User::whereId($request->user_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } else {
            return apiReqponse('', false, 'User with ID 1 cannot be deleted.', BAD_REQUEST);
        }
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function restore(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            User::whereId($request->user_id)->restore();
            return apiReqponse('', true, DATA_RESTORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    //test function for copy

}
