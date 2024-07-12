<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Roles;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AddressesController extends Controller
{


    public function index(Request $request)
    {
        try {
            $data = Address::with(['user:id,name'])->orderBy("id", "asc");
            if ($request->is_active !== null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('addresse_id')) {
                $data = $data->where("id", $request->addresse_id);
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
                'address_line1' => ['required'],
                'city' => ['required'],
                'postel_code' => ['required'],
                'mobile_no' => ['required']
            ]
        );

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {

            if ($request->addresse_id == 1 && $request->addresse_id == 2) {
                return apiReqponse('', false, ADMIN_ROLE, BAD_REQUEST);
            }
            $userObj = new Address;
            $userObj->user_id = $request->user_id;
            $userObj->address_line1 = $request->address_line1;
            $userObj->address_line2 = $request->address_line2;
            $userObj->city = $request->city;
            $userObj->postel_code = $request->postel_code;
            $userObj->mobile_no = $request->mobile_no;
            $userObj->save();
            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }



    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => ['required'],
            'address_line1' => ['required'],
            'city' => ['required'],
            'postel_code' => ['required'],
            'mobile_no' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Address::find($request->addresse_id);
            $obj->user_id = $request->user_id;
            $obj->address_line1 = $request->address_line1;
            $obj->address_line2 = $request->address_line2;
            $obj->city = $request->city;
            $obj->postel_code = $request->postel_code;
            $obj->mobile_no = $request->mobile_no;
            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        try {
            Address::whereId($request->addresse_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

}
