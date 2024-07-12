<?php

namespace App\Http\Controllers;

// use App\Models\Image;

use App\Models\Image;
use App\Models\Product;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = Product::with(['category:id,name', 'brand:id,name,image', 'images'])->latest();

            if ($request->is_active !== null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('product_id')) {
                $data = $data->where("id", $request->product_id);
            }
            $data = $data->get();
            return apiReqponse($data, true, DATA_FATCHED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function show(Request $request)
    {
        try {
            $data = Product::with(['category:id,name', 'brand:id,name', 'images']);

            if ($request->is_active !== null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('product_id')) {
                $data = $data->where("id", $request->product_id);
            }
            $data = $data->first();
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
                'category_id' => ['required'],
                'brand_id' => ['required'],
                'mrp' => ['required'],
                'sale_price' => ['required'],
                'quantity' => ['required'],
                'size' => ['required'],
                'image*' => 'required|mimes:jpeg,png,jpg,webp|max:2048',
                'thumbnail' => 'required|mimes:jpeg,png,jpg,webp|max:2048',
            ]
        );

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = new Product;
            $obj->name = $request->name;
            $obj->category_id = $request->category_id;
            $obj->brand_id = $request->brand_id;
            $obj->mrp = $request->mrp;
            $obj->sale_price = $request->sale_price;
            $obj->discription = $request->discription;
            $obj->quantity = $request->quantity;
            $obj->discounted_price = $request->discounted_price;
         
            $obj->is_active = $request->is_active;
            $obj->is_feature = $request->is_feature;
            $obj->is_deal = $request->is_deal;
            // $obj->min_quantity = $request->min_quantity;
            // $obj->max_quantity = $request->max_quantity;
            $obj->size = $request->size;
            /* if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = uniqid() . '_' . time() . '.' . $thumbnail->getClientOriginalExtension();
                $destinationPath = public_path('storage/product/thumbnails');
                $thumbnail->move($destinationPath, $thumbnailName);
                $obj->thumbnail =  $thumbnailName;
            } */

            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = uniqid() . '_' . time() . '.' . $thumbnail->getClientOriginalExtension();
                $thumbnail->storeAs('public/product/thumbnails', $thumbnailName);
                $obj->thumbnail =  $thumbnailName;
            }
            $obj->save();
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $imageName = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/product', $imageName); // Store the image in the storage
                    $img = new Image();
                    $img->product_id = $obj->id;
                    $img->image = $imageName;
                    $img->save();
                }
            }
            
            $obj->save();

            return apiReqponse($obj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }


    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required'],
            'category_id' => ['required'],
            'brand_id' => ['required'],
            'mrp' => ['required'],
            'sale_price' => ['required'],
            'quantity' => ['required'],
            'size' => ['required'],
            
            // 'discounted_price' => ['required'],
            
            'image*' => 'required|mimes:jpeg,png,jpg,webp|max:2048',
            // 'is_active' => ['required'],
            // 'is_feature' => ['required'],
            // 'is_deal' => ['required'],
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }

        try {
            $product = Product::find($request->product_id);
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->mrp = $request->mrp;
            $product->sale_price = $request->sale_price;
            $product->discription = $request->discription;
            $product->quantity = $request->quantity;
          
            $product->discounted_price = $request->discounted_price;
           
            $product->is_active = $request->is_active;
            $product->is_feature = $request->is_feature;
            $product->is_deal = $request->is_deal;
            // $product->min_quantity = $request->min_quantity;
            // $product->max_quantity = $request->max_quantity;
            $product->size = $request->size;

            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = uniqid() . '_' . time() . '.' . $thumbnail->getClientOriginalExtension();
                $destinationPath = public_path('storage/product/thumbnails');
                $thumbnail->move($destinationPath, $thumbnailName);
                $product->thumbnail = $thumbnailName;
            }
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = storage_path('app/public/product/',);
                    $image->move($destinationPath, $imageName);
                    $img = new Image();
                    $img->image = $imageName;
                    $img->product_id = $product->id;
                    $img->save();
                }
            }

            $product->save();

          
            $product->save();
            return apiReqponse($product, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }


    public function delete(Request $request)
    {
        try {
            Product::whereId($request->id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
