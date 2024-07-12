<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
{

    public function index(Request $request)
    {
        try {
            $data = Payment::with(['user:id,name','order:id,total'])-> orderBy("id", "asc");
            if ($request->is_active!==null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('payment_id')){
                $data = $data->where("id", $request->payment_id);
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
                'order_id' => ['required'],
                'payment_method' => ['required'],
                'transaction_id' => ['required'],
                'status' => ['required']
            ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $userObj = new Payment;
            $userObj->user_id = $request->user_id;
            $userObj->order_id = $request->order_id;
            $userObj->payment_method = $request->payment_method;
            $userObj->transaction_id = $request->transaction_id;
            $userObj->status = $request->status;
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
            'order_id' => ['required'],
            'payment_method' => ['required'],
            'transaction_id' => ['required'],
            'status' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Payment::find($request->payment_id);
            $obj->user_id = $request->user_id;
            $obj->order_id = $request->order_id;
            $obj->payment_method = $request->payment_method;
            $obj->transaction_id = $request->transaction_id;
            $obj->status = $request->status;
            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        try {
            Payment::whereId($request->payment_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
