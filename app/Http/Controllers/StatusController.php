<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    // public function Accepted(Request $request)
    // {
      
    //     $data = $request->all(); 

        
    //     return response()->json(['message' => 'Your response message'], 200);
    // }
    // public function getAcceptedStatus()
    // {
    //     return response()->json(['status' => 'accepted'], 200);
    // }
    public function index(Request $request)
    {
        try {
            $data = Status::orderBy("id", "asc");
            if ($request->is_active!==null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('status_id')){
                $data = $data->where("id", $request->status_id);
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
            ]);
 
        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $userObj = new Status;
            $userObj->name = $request->name;
            $userObj->save();
            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
