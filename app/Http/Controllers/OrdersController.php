<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{

    public function index(Request $request)
    {
        try {
            $data = Order::with(['address','user','status','product:id,name'])->orderBy("id", "asc");
            if ($request->is_active !== null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('order_id')) {
                $data = $data->where("id", $request->order_id);
            }
            if ($request->has('status_id')) {
                $data = $data->whereHas('status', function ($query) use ($request) {
                    $query->where('id', $request->status_id);
                });
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
                'address_id' => ['required'],
                'tracking_id' => ['required'],
                'status_id' => ['required'],
                'payment_status' => ['required'],
                'total' => ['required'],
                'product_id' => ['required'],
            ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {

            if ($request->order_id == 1 && $request->order_id == 2) {
                return apiReqponse('', false, ADMIN_ROLE, BAD_REQUEST);
            }
            $userObj = new Order;
            $userObj->user_id = $request->user_id;
            $userObj->address_id = $request->address_id;
            $userObj->tracking_id = $request->tracking_id;
            $userObj->description = $request->description;
            $userObj->status_id = $request->status_id;
            $userObj->product_id = $request->product_id;
            $userObj->order_no = $request->order_no;
            $userObj->payment_status = $request->payment_status;
            $userObj->total = $request->total;
            $userObj->date = $request->date;
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
            'address_id' => ['required'],
            'tracking_id' => ['required'],
            'status_id' => ['required'],
            'payment_status' => ['required'],
            'total' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Order::find($request->order_id);
            $obj->user_id = $request->user_id;
            $obj->address_id = $request->address_id;
            $obj->tracking_id = $request->tracking_id;
            $obj->description = $request->description;
            $obj->status_id = $request->status_id;
            $obj->product_id = $request->product_id;
            $obj->order_no = $request->order_no;
            $obj->payment_status = $request->payment_status;
            $obj->total = $request->total;
            $obj->date = $request->date;
            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        try {
            Order::whereId($request->order_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
