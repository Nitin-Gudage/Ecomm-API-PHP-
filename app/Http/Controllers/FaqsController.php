<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use Exception;
use Illuminate\Support\Facades\Validator;

class FaqsController extends Controller
{ 
    
    public function index(Request $request)
    {
        try {
            $data = Faq::with(['user:id,name'])-> orderBy("id", "asc");
            if ($request->is_active!==null) {
                $data = $data->where("is_active", $request->is_active);
            }
            if ($request->has('faq_id')){
                $data = $data->where("id", $request->faq_id);
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
                'quation' => ['required'],
                'answer' => ['required']
            ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {

            if ($request->faq_id == 1 && $request->faq_id == 2) {
                return apiReqponse('', false, ADMIN_ROLE, BAD_REQUEST);
            }
            $userObj = new Faq;
            $userObj->user_id= $request->user_id;
            $userObj->quation= $request->quation;
            $userObj->answer= $request->answer;
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
            'quation' => ['required'],
            'answer' => ['required']
        ]);

        if ($validation->fails()) {
            $error = $validation->errors()->first();
            return apiReqponse('', false, $error, BAD_REQUEST);
        }
        try {
            $obj = Faq::find($request->faq_id);
            $obj->user_id= $request->user_id;
            $obj->quation= $request->quation;
            $obj->answer= $request->answer;
            $obj->save();
            return apiReqponse($obj, true, DATA_UPDATED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        try {
            Faq::whereId($request->faq_id)->delete();
            return apiReqponse('', true, DATA_DELETED, STATUS_OK);
        } catch (Exception $e) {
            return apiReqponse('', false, $e->getMessage(), BAD_REQUEST);
        }
    }
}
