<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class BrandsController extends Controller
{

    public function index(Request $request)
    {
        try {
            $data = Brand::orderBy("id", "asc");
            if ($request->is_active!==null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('brand_id')){
                $data = $data->where("id", $request->brand_id);
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
                'description' => ['required'],
                'image' => 'sometimes|image|max:5000',
            
            ]);
 
        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $userObj = new Brand;
            $userObj->name = $request->name;
            $userObj->is_active = $request->is_active;
            $userObj->description = $request->description;
            $userObj->image = $request->image;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
    
                if ($image->isValid() && strpos($image->getMimeType(), 'image/') === 0) {
                    $fileName = "brand-" . uniqid() . time() . '.' . $image->getClientOriginalExtension();
                    $filePath = $image->storeAs('public/brand/', $fileName);
                    $path = $image->move(public_path('storage/brand/'), $fileName);  
                    $url = url('storage/brand/' . $fileName);
                    $userObj->image = $url; // Store URL in the image column
                }
            }
            $userObj->save();
            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
 
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            //'brand_id'=>['required|exists:brand,id'],
            'name' => ['required', 'unique:users,name,' . $request->brand_id],
            'description' => ['required'],
            'image' => ['required'],
        ]);
 
        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Brand::find($request->brand_id);
            $obj->name = $request->name;
            $obj->is_active = $request->is_active;
            $obj->description = $request->description;
            $obj->image = $request->image;
            $obj->save();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
        
                if ($image->isValid() && strpos($image->getMimeType(), 'image/') === 0) {
                    $fileName = "brand-" . uniqid() . time() . '.' . $image->getClientOriginalExtension();
                    
                   
                    if ($obj->image && Storage::exists(str_replace(url('brand'), 'public', $obj->image))) {
                        Storage::delete(str_replace(url('brand'), 'public', $obj->image));
                    }
                    
                 
                    $filePath = $image->storeAs('public/brand/', $fileName);
        
                  
                    $path = $image->move(public_path('storage/brand/'), $fileName);
        
                   
                    $url = url('storage/brand/' . $fileName);
        
                    
                    $obj->image = $url;
                }
            }
            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
 
    public function delete(Request $request)
    {
        try {
            Brand::whereId($request->brand_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function show(Request $request)
    {
        $validation = Validator::make($request->all(), [
        
        ]);
 
        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Brand::find($request->brand_id);
        
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
    
}
