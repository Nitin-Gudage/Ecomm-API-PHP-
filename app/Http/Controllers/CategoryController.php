<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // public function index(Request $request)
    // {
    //     try {
    //         $data = Category::orderBy("id", "asc");
    //         if ($request->is_active !== null) {
    //             $data = $data->where("is_active", $request->is_active);
    //         }
    //         if ($request->has('category_id')) {
    //             $data = $data->where("id", $request->category_id);
    //         }
    //         $data = $data->get();
    //         return apiReqponse($data, true, DATA_FATCHED, STATUS_OK);
    //     } catch (Exception $e) {
    //         return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
    //     }
    // }


    //     public function index(Request $request)
    // {
    //     try {
    //         $data = Category::orderBy("id", "asc");
    //         if ($request->is_active !== null) {
    //             $data = $data->where("is_active", $request->is_active);
    //         }
    //         if ($request->has('category_id')) {
    //             $data = $data->where("id", $request->category_id);
    //         }
    //         $categories = $data->get();
    //         // Fetch subcategories for each category
    //         foreach ($categories as $category) {
    //             $category->subcategories = Category::where('parent_id', $category->id)->get();
    //         }

    //         return apiReqponse($categories, true, DATA_FATCHED, STATUS_OK);
    //     } catch (Exception $e) {
    //         return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
    //     }
    // }


    // public function index(Request $request)
    // {
    //     try {
    //         $query = Category::orderBy("id", "asc");
    //         if ($request->has('is_active')) {
    //             $query->where("is_active", $request->is_active);
    //         }
    //         if ($request->has('category_id')) {
    //             // Find the category by its ID
    //             $category = $query->find($request->category_id);
    //             if (!$category) {
    //                 return apiReqponse('', false, 'Category not found', NOT_FOUND);
    //             }
    //             $category->subcategories = Category::where('parent_id', $category->id)->get();
    //             return apiReqponse($category, true, DATA_FATCHED, STATUS_OK);
    //         }

    //         $categories = $query->get();

    //         foreach ($categories as $category) {
    //             $category->subcategories = Category::where('parent_id', $category->id)->get();
    //         }
    //         return apiReqponse($categories, true, DATA_FATCHED, STATUS_OK);
    //     } catch (Exception $e) {
    //         return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
    //     }
    // }



    public function index(Request $request)
{
    try {
        $query = Category::query(); 
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }
            $parentId = $request->parent_id ?? "";
            if (empty($parentId)) {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $parentId);
            }
        $data = $query->with('parent')->orderBy('id', 'asc')->get();
 
        return apiReqponse($data, true, 'Data fetched successfully', STATUS_OK);
    } catch (Exception $e) {
        return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
    }
}






    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => ['required', 'unique:categories,name'],
            // 'parent_id' => ['required'],
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {

            $userObj = new Category;
            $userObj->name = $request->name;
            $userObj->parent_id = $request->parent_id ?? null;
            $userObj->is_active = $request->is_active;
            $userObj->save();
            return apiReqponse($userObj, true, DATA_STORE, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            // 'name' => ['required', 'unique:categories,name,id' . $request->category_id],
            // 'category_id' => ['required'],
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Category::find($request->category_id);
            $obj->name = $request->name;
            $obj->parent_id = $request->parent_id ?? null;
            $obj->is_active = $request->is_active;
            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }


    public function delete(Request $request)
    {
        try {
            Category::whereId($request->category_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
