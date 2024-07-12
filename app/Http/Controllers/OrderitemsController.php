<?php

namespace App\Http\Controllers;

use App\Models\Orderitems;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderitemsController extends Controller
{
    public function index(Request $request)
    {
       
        try {
            $data = Orderitems::with(['order:id','product:id,name'])-> orderBy("id", "asc");
            if ($request->is_active!==null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('orderitem_id')){
                $data = $data->where("id", $request->orderitem_id);
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
                'order_id' => ['required'],
                'quantity' => ['required'],
                'product_id' => ['required'],
                'price' => ['required']
            ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {

            if ($request->orderitem_id == 1 && $request->orderitem_id == 2) {
                return apiReqponse('', false, ADMIN_ROLE, BAD_REQUEST);
            }
            $userObj = new Orderitems;
            $userObj->order_id = $request->order_id;
            $userObj->quantity = $request->quantity;
            $userObj->product_id = $request->product_id;
            $userObj->price = $request->price;
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
            'order_id' => ['required'],
                'quantity' => ['required'],
                'product_id' => ['required'],
                'price' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Orderitems::find($request->orderitem_id);
            $obj->order_id = $request->order_id;
            $obj->quantity = $request->quantity;
            $obj->product_id = $request->product_id;;
            $obj->price = $request->price;
            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        try {
            Orderitems::whereId($request->orderitem_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

}
