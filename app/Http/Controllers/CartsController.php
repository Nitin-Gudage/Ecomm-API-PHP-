<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartsController extends Controller
{
 
    public function index(Request $request)
    {
        try {
            $data = Cart::with(['user:id,name','product:id,name','product.images'])->orderBy("id", "asc");
            if ($request->is_active!==null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('cart_id')){
                $data = $data->where("id", $request->cart_id);
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
                'product_id' => ['required'],
                'quantity' => ['required'],
                'color' => ['required'],
                'size' => ['required'],
                'price' => ['required'],
                
            ]);
 
        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $userObj = new Cart;
            $userObj->user_id = $request->user_id;
            $userObj->product_id = $request->product_id;
            $userObj->quantity = $request->quantity;
            $userObj->color = $request->color;
            $userObj->size = $request->size;
            $userObj->price = $request->price;
            $userObj->save();
            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
 
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            // 'name' => ['required', 'unique:users,name,' . $request->brand_id],
            // 'is_active' => ['required'],
            // 'user_id' => ['required', 'exists:users,id']
        ]);
 
        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Cart::find($request->cart_id);
            $obj->user_id = $request->user_id;
            $obj->color = $request->color;
            $obj->price = $request->price;
            $obj->product_id = $request->product_id;
            $obj->quantity = $request->quantity;
            $obj->size = $request->size;

            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
 
    public function delete(Request $request)
    {
        try {
            Cart::whereId($request->cart_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
 
}