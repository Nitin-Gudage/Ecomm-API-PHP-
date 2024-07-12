<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewsController extends Controller
{

    public function index(Request $request)
    {
        try {
            $data = Review::with(['user:id,name', 'product:id,name'])->orderBy("id", "asc");
            if ($request->is_active !== null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('review_id')) {
                $data = $data->where("id", $request->review_id);
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
                'rating' => ['required',],
                'comment' => ['required']
            ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {

            $userObj = new Review;
            $userObj->user_id = $request->user_id;
            $userObj->product_id = $request->product_id;
            $userObj->rating = $request->rating;
            $userObj->comment = $request->comment;
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
            'rating' => ['required',],
            'comment' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Review::find($request->review_id);
            $obj->user_id = $request->user_id;
            $obj->product_id = $request->product_id;
            $obj->rating = $request->rating;
            $obj->comment = $request->comment;
            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        try {
            Review::whereId($request->review_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
