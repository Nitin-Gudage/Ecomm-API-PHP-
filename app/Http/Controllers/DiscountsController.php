<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountsController extends Controller
{

    public function index(Request $request)
    {
        try {
            $data = Discount::with(['product',])->orderBy("id", "asc");
            if ($request->is_active !== null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('discount_id')) {
                $data = $data->where("id", $request->discount_id);
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
                'name' => ['required'],
                'product_id' => ['required'],
                'discount_types' => ['required'],
                'coupon_id' => ['required']
            ]
        );

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $userObj = new Discount;
            $userObj->name = $request->name;
            $userObj->product_id = $request->product_id;
            $userObj->discount_types = $request->discount_types;
            $userObj->coupon_id = $request->coupon_id;
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
            'name' => ['required'],
            'product_id' => ['required'],
            'discount_types' => ['required'],
            'coupon_id' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Discount::find($request->discount_id);
            $obj->name = $request->name;
            $obj->product_id = $request->product_id;
            $obj->discount_types = $request->discount_types;
            $obj->coupon_id = $request->coupon_id;
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
            Discount::whereId($request->discount_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
