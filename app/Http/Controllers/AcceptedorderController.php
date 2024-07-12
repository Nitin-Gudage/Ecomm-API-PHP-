<?php

namespace App\Http\Controllers;

use App\Models\Acceptedorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class AcceptedorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $data = Acceptedorder::with(['address','user','product','orderitem'])->orderBy("id", "asc");
            // if ($data->is_active !== null) {
            //     $data = $data->where("is_active", $request->is_active);
            // }
            if ($request->has('acceptedorder_id')) {
                $data = $data->where("id", $request->order_id);
            }
            $data = $data->get();
            return apiReqponse($data, true, DATA_FATCHED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'orderitem_id' => ['required'],
                'product_id' => ['required'],
                'user_id' => ['required'],
                'payment_status' => ['required'],
                'address_id' => ['required'],
                'tracking_id' => ['required'],
                'quantity' => ['required'],
            ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {

            if ($request->acceptedorder_id == 1 && $request->acceptedorder_id == 2) {
                return apiReqponse('', false, ADMIN_ROLE, BAD_REQUEST);
            }
            $userObj = new Acceptedorder;
            $userObj->orderitem_id = $request->orderitem_id;
            $userObj->product_id = $request->product_id;
            $userObj->user_id = $request->user_id;
            $userObj->payment_status = $request->payment_status;
            $userObj->address_id = $request->address_id;
            $userObj->tracking_id = $request->tracking_id;
            $userObj->quantity = $request->quantity;
            $userObj->save();
            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\acceptedorder  $acceptedorder
     * @return \Illuminate\Http\Response
     */
    public function show(acceptedorder $acceptedorder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\acceptedorder  $acceptedorder
     * @return \Illuminate\Http\Response
     */
    public function edit(acceptedorder $acceptedorder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\acceptedorder  $acceptedorder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, acceptedorder $acceptedorder)
    {
        $validation = Validator::make($request->all(),
         [
            'orderitem_id' => ['required'],
            'product_id' => ['required'],
            'user_id' => ['required'],
            'payment_status' => ['required'],
            'address_id' => ['required'],
            'tracking_id' => ['required'],
            'quantity' => ['required'],
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = new Acceptedorder;
            $obj->orderitem_id = $request->orderitem_id;
            $obj->product_id = $request->product_id;
            $obj->user_id = $request->user_id;
            $obj->payment_status = $request->payment_status;
            $obj->address_id = $request->address_id;
            $obj->tracking_id = $request->tracking_id;
            $obj->quantity = $request->quantity;
            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\acceptedorder  $acceptedorder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            Acceptedorder::whereId($request->acceptedorder_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
