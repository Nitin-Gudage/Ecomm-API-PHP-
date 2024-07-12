<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Returnorder;
use Exception;
use Illuminate\Support\Facades\Validator;

class ReturnordersController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = Returnorder::with(['user:id,name', 'order:id,total,product_id'])->orderBy("id", "asc");
            if ($request->is_active !== null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('returnorder_id')) {
                $data = $data->where("id", $request->returnorder_id);
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
                'quantity' => ['required'],
                'order_id' => ['required'],
                'status' => ['required'],
                'reason' => ['required'],
                'total' => ['required']
            ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $userObj = new Returnorder;
            $userObj->user_id = $request->user_id;
            $userObj->quantity = $request->quantity;
            $userObj->order_id = $request->order_id;
            $userObj->prize = $request->prize;
            $userObj->status = $request->status;
            $userObj->reason = $request->reason;
            $userObj->returnorder_date = $request->returnorder_date;
            $userObj->total = $request->total;
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
            // 'user_id' => ['required'],
            // 'quantity' => ['required'],
            // 'order_id' => ['required'],
            // 'status' => ['required'],
            // 'reason' => ['required'],
            // 'total' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Returnorder::find($request->returnorder_id);
            $obj->user_id = $request->user_id;
            $obj->quantity = $request->quantity;
            $obj->order_id = $request->order_id;
            $obj->status = $request->status;
            $obj->prize = $request->prize;
            $obj->returnorder_date = $request->returnorder_date;
            $obj->reason = $request->reason;
            $obj->total = $request->total;
            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        try {
            Returnorder::whereId($request->returnorder_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
