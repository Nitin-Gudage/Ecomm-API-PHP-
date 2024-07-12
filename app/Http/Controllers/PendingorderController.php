<?php

namespace App\Http\Controllers;

use App\Models\Pendingorder;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class PendingorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            
            $data = Pendingorder::with(['user','order','product'])->orderBy("id", "desc");
            if ($request->is_active !== null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('pendingorder_id')) {
                $data = $data->where("id", $request->pendingorder_id);
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
                'user_id' => ['required'],
                'quantity' => ['required'],
                'product_id' => ['required'],
                'order_id' => ['required'],
                'reason' => ['required'],
                'total' => ['required']
            ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $userObj = new Pendingorder;
            $userObj->user_id = $request->user_id;
            $userObj->quantity = $request->quantity;
            $userObj->status = $request->status;
            $userObj->pendingorder_date = $request->pendingorder_date;
            $userObj->product_id = $request->product_id;
            $userObj->order_id = $request->order_id;
            $userObj->prize = $request->prize;
            $userObj->reason = $request->reason;
            $userObj->total = $request->total;
            $userObj->save();
            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pendingorder  $pendingorder
     * @return \Illuminate\Http\Response
     */
    public function show(Pendingorder $pendingorder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pendingorder  $pendingorder
     * @return \Illuminate\Http\Response
     */
    public function edit(Pendingorder $pendingorder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pendingorder  $pendingorder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pendingorder $pendingorder)
    {
        $validation = Validator::make($request->all(),
        [
                // 'user_id' => ['required'],
                // 'quantity' => ['required'],
                // 'product_id' => ['required'],
                // 'order_id' => ['required'],
                // 'reason' => ['required'],
                // 'total' => ['required']
       ]);

       if ($validation->fails()) {
           $error = $validation->errors()->first();
           return apiReqponse('', false, $error, BAD_REQUEST);
       }
       try {
           $obj = Pendingorder::find($request->pendingorder_id);
           $obj->user_id = $request->user_id;
           $obj->quantity = $request->quantity;
           $obj->status = $request->status;
           $obj->pendingorder_date = $request->pendingorder_date;
            $obj->product_id = $request->product_id;
            $obj->order_id = $request->order_id;
            $obj->prize = $request->prize;
            $obj->reason = $request->reason;
            $obj->total = $request->total;
            $obj->save();
           return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
       } catch (Exception $e) {
           return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pendingorder  $pendingorder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            Pendingorder::whereId($request->pendingorder_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
