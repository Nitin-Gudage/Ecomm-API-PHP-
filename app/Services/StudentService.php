<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentDocument;
use Illuminate\Routing\Controller as BaseController;

class StudentService extends BaseController
{
    static function addStudent($request, $id)
    {
        $stdData = new Student;
        $stdData->user_id = $id;
        $stdData->first_name = $request['first_name'] ?? "";
        $stdData->last_name = $request['last_name'] ?? "";
        $stdData->middle_name = $request['middle_name'] ?? "";
        $stdData->email = $request['email'] ?? "";
        $stdData->dob = (string)$request['dob'] ?? "";
        $stdData->country_id = $request['country_id'] ?? "";
        $stdData->passport_number = $request['passport_number'] ?? "";
        $stdData->passport_expiry = $request['passport_expiry'] ?? "";
        $stdData->marital_status = $request['marital_status'] ?? "";
        $stdData->gender = $request['gender'] ?? "";
        $stdData->mobile = $request['mobile'] ?? "";
        $stdData->referral_source = $request['referral_source'] ?? "";
        $stdData->interest_country_id = $request['interest_country_id'] ?? "";
        $stdData->service_interest = $request['service_interest'] ?? "";
        $stdData->created_by = auth()->user()->user_type == 'student' ? 1 : auth()->user()->id;
        $stdData->report_to = 1;
        $stdData->parent_id = auth()->user()->user_type == 'student' ? 1 : auth()->user()->parent_id;
        $stdData->save();
        // $loc = auth()->user()->user_type == 'student' ? "STD" : auth()->user()->parent->prefix;
        // $pp = auth()->user()->user_type == 'student' ? "DIR" : (auth()->user()->parent_id == 1 ? "EMP" : 'PP');
        // $stdData->student_id = STUDENT_PREFIX.'-'.$pp.'-'.$loc.'-'.STUDENT_START.'-'. str_pad($stdData->id, 4, '0', STR_PAD_LEFT);
        $stdData->student_id = STUDENT_PREFIX.str_pad(STUDENT_START.''.$stdData->id, 6, '0', STR_PAD_LEFT);
        $stdData->save();
        return $stdData;
    }
}
