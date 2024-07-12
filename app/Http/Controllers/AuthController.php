<?php

namespace App\Http\Controllers;

use App\Mail\SendCodeResetPassword;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'unique:users'],
            'password' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $userObj = new User;
            $userObj->name = $request->name;
            $userObj->mobile = $request->mobile ?? "";
            $userObj->email = $request->email;
            $userObj->password = Hash::make($request->password);
            // $userObj->user_type = 'student';
            $userObj->role_id = 1;
            $userObj->is_active = true;
            // $userObj->parent_id = 1;
            // $userObj->created_by = 1;
            $userObj->save();
            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $user = User::where('email', $request->email)->whereNull('deleted_at')->first();
            if ($user) {
                if (!$user->is_active) {
                    return apiReqponse('', false, ACCOUNT_SUSPENDED, BAD_REQUEST);
                }
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    $user->token =  $user->createToken('getapp')->accessToken;
                    // $user->permissions = []; //menu($user->role_id, $baseUrl);
                    // $user->role_permissions = []; //getRolePermissions($user->role_id);
                    $baseUrl = '';
                    $user['permissions'] = menu($user->role_id,$baseUrl);
                    $user['role_permissions'] = getRolePermissions($user->role_id);
                    return apiReqponse($user, true, LOGIN_SUCCESS, STATUS_OK);
                } else {
                    return apiReqponse('', false, PASSWORD_MISMATCHED, BAD_REQUEST);
                }
            } else {
                return apiReqponse('', false, CREDANTIAL_MISMATCHED, BAD_REQUEST);
            }
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function sendMail(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            DB::table('password_resets')->where('email', $request->email)->delete();
            $data = $request->all();
            $data['token'] = mt_rand(100000, 999999);
            DB::table('password_resets')->insert($data);
            Mail::to($request->email)->send(new SendCodeResetPassword($data['token']));
            return apiReqponse('', true, OTP_SEND, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function verifyOTP(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'otp' => ['required'],
            'password' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $data = DB::table('password_resets')->where('token', $request->otp)->first();
            if ($data) {
                User::where('email', $data->email)->update([
                    'password' => Hash::make($request->password)
                ]);
                DB::table('password_resets')->where('email', $data->email)->delete();
                return apiReqponse('', true, PASSWORD_RESET, STATUS_OK);
            } else {
                return apiReqponse('', false, OTP_WRONG, BAD_REQUEST);
            }
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
