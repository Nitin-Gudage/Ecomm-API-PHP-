<?php

namespace App\Http\Controllers;

use App\Models\Addtocart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class AddtocartController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = Addtocart::with(['product:id,name,image'])->orderBy("id", "asc");
            if ($request->is_active!==null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('addtocart_id')){
                $data = $data->where("id", $request->addtocart_id);
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
                'product_id' => ['required'],
                'quantity' => ['required'],
                'price' => ['required'],
                'size' => ['required'],
                // 'image' => 'nullable|image|max:2048',
            ]);
 
        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
 
            if ($request->addtocart_id == 1 && $request->addtocart_id == 2) {
                return apiReqponse('', false, ADMIN_ROLE, BAD_REQUEST);
            }
            $userObj = new Addtocart;
            $userObj->product_id= $request->product_id;
            $userObj->quantity= $request->quantity;
            $userObj->size= $request->size;
            $userObj->price= $request->price;
            $userObj->save();
            $userObj->image = $request->image;
            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
    
            //     if ($image->isValid() && strpos($image->getMimeType(), 'image/') === 0) {
            //         $fileName = "addtocart-" . uniqid() . time() . '.' . $image->getClientOriginalExtension();
            //         $filePath = $image->storeAs('public/addtocart/', $fileName);
    
                  
            //         $path = $image->move(public_path('storage/addtocart/'), $fileName);
    
            //         $url = url('storage/addtocart/' . $fileName);
    
            //         $userObj->image = $url; // Store URL in the image column
            //     }
            // }
            $userObj->save();
            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

 
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'product_id' => ['required'],
            'quantity' => ['required'],
            'price' => ['required'],
            'size' => ['required'],
            // 'image' => ['required'],
        ]);
 
        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Addtocart::find($request->addtocart_id);
            $obj->product_id= $request->product_id;
            $obj->quantity= $request->quantity;
            $obj->size= $request->size;
            $obj->price= $request->price;
            $obj->save();
            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
        
            //     if ($image->isValid() && strpos($image->getMimeType(), 'image/') === 0) {
            //         $fileName = "addtocart-" . uniqid() . time() . '.' . $image->getClientOriginalExtension();
                    
                   
            //         if ($obj->image && Storage::exists(str_replace(url('storage'), 'public', $obj->image))) {
            //             Storage::delete(str_replace(url('storage'), 'public', $obj->image));
            //         }
                    
                 
            //         $filePath = $image->storeAs('public/addtocart/', $fileName);
        
                  
            //         $path = $image->move(public_path('storage/addtocart/'), $fileName);
        
                   
            //         $url = url('storage/addtocart/' . $fileName);
        
                    
            //         $obj->image = $url;
            //     }
            // }
            $obj->save();
            
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
 
    public function delete(Request $request)
    {
        try {
            Addtocart::whereId($request->addtocart_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
    

}
