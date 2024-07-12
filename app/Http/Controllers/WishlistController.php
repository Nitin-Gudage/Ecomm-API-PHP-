<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = Wishlist::with(['user:id,name','product:id,name,sale_price','product.images',])-> orderBy("id", "asc");
            
            if ($request->is_active!==null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('wishlist_id')){
                $data = $data->where("id", $request->wishlist_id);
            }
            $data = $data->get();
            // $data = Wishlist::with(['user:id,name', 'product:id,name,image'])-> orderBy("id", "asc");
            // $transformedData = $data->map(function ($item) {
            //     $userData = $item->user ? ['id' => $item->user->id, 'name' => $item->user->name] : null;
            //     $productData = $item->product ? ['id' => $item->product->id, 'name' => $item->product->name, 'image_url' => $item->product->image_url] : null;
    
            //     return [
            //         'id' => $item->id,
            //         'user' => $userData,
            //         'product' => $productData
            //     ];
            // });
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
                
            ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $userObj = new Wishlist();
            $userObj->user_id = $request->user_id;
            $userObj->product_id = $request->product_id;
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
            'product_id' => ['required'],
           
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Wishlist::find($request->wishlist_id);
            $obj->user_id = $request->user_id;
            $obj->product_id = $request->product_id;
            $obj->save(); 
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        try {
            Wishlist::whereId($request->wishlist_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
