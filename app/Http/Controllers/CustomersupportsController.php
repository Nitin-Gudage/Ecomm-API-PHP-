<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customersupport;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;

class CustomersupportsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = Customersupport::with(['user'])-> orderBy("id", "asc");
            if ($request->is_active!==null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('customersupport_id')){
                $data = $data->where("id", $request->customersupport_id);
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
                'user_id' => ['required'],
                'first_name' => ['required'],
                'email' => ['required'],
                'last_name' => ['required']
            ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $userObj = new Customersupport;
            $userObj->user_id = $request->user_id;
            $userObj->first_name = $request->first_name;
            $userObj->last_name = $request->last_name;
            $userObj->email = $request->email;
            $userObj->save();
            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(),
         [
            'user_id' => ['required'],
            'first_name' => ['required'],
            'email' => ['required'],
            'last_name' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Customersupport::find($request->customersupport_id);
            $obj->user_id = $request->user_id;
            $obj->first_name = $request->first_name;
            $obj->last_name = $request->last_name;
            $obj->email = $request->email;
            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        try {
            Customersupport::whereId($request->customersupport_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
