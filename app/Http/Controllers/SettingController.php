<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Setting::whereIn('key', ['terms_conditions', 'privacy_policy', 'copyright', 'Website_title', 'title_descriptions', 'logo', 'mobile_logo', 'favicon_logo'])
                ->orderBy("id", "asc")
                ->pluck('value', 'key')
                ->toArray();
     
            
         
                $data['logo'] = asset(IMGPREFIX.'storage/uploads/' . $data['logo']) ?? null;
         
                $data['mobile_logo'] = asset(IMGPREFIX.'storage/uploads/' . $data['mobile_logo'])?? null;
           
                $data['favicon_logo'] = asset(IMGPREFIX.'storage/uploads/' . $data['favicon_logo'])?? null;
           
     
            return response()->json(['data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        try {
            $validator = Validator::make($request->all(), [
                'key' => 'required|string|in:terms_conditions,privacy_policy,copyright,Website_title,title_descriptions,logo,mobile_logo,favicon_logo,smtp_credential,prefix,working_days,working_time',
                'value' => 'required',
            ]);
 
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
 
            $keyToUpdate = $request->input('key');
            $setting = Setting::where('key', $keyToUpdate)->first();
            if (!$setting) {
                return response()->json(['error' => 'Setting not found'], 404);
            }
 
            $newValue = $request->input('value');
 
           
            if ($request->hasFile('value') && in_array($keyToUpdate, ['logo', 'mobile_logo', 'favicon_logo'])) {
                $imageFile = $request->file('value');
                $imageName = time() . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->storeAs('public/uploads', $imageName);
                $newValue = $imageName; // Update value to store the file names
            }
 
            // Update SMTP credentials
            if (in_array($keyToUpdate, [
                'host' => 'required',
                'port' => 'required',
                'username' => 'required',
                'password' => 'required',
                'from' => 'required',
                'name' => 'required'
            ])) {
               
                $smtpCredentials = json_decode($newValue, true);
                if (!$smtpCredentials) {
                    return response()->json(['error' => 'Invalid format for SMTP credentials'], 422);
                }
               
                $newValue = json_encode($smtpCredentials);
            }
            if ($keyToUpdate === 'working_days') {
                
                $workingDays = $newValue;
                
                if (!is_array($workingDays)) {
                    return response()->json(['error' => 'Invalid format for working days'], 422);
                }
                // Assuming $newValue holds an array like ['Monday' => true, 'Tuesday' => false, ...]
                $newValue = json_encode($workingDays);
            }
            if ($keyToUpdate === 'working_time') {
               
                $workingTime = $newValue;
                
                if (!is_array($workingTime)) {
                    return response()->json(['error' => 'Invalid format for working days'], 422);
                }
               
                $newValue = json_encode($workingTime);
            }
            $setting->update([
                'value' => $newValue,
            ]);
 
            return response()->json('updated successfully', 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function list(Request $request)
    {
        try {
            $data = Setting::whereIn('key', ['terms_conditions', 'privacy_policy'])
                ->orderBy("id", "asc")
                ->pluck('value', 'key')
                ->toArray();
 
            // Replace null values with empty strings
            foreach ($data as $key => $value) {
                if ($value === null) {
                    $data[$key] = '';
                }
            }
            return response()->json(['data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function smtpCredential(Request $request)
    {
        try {
            $data = Setting::whereIn('key', ['smtp_credential'])
                ->orderBy("id", "asc")
                ->pluck('value', 'key')
                ->toArray();
 
            // Replace null values with empty strings
            foreach ($data as $key => $value) {
                if ($value === null) {
                    $data[$key] = '';
                }
            }
 
            // Handle SMTP credential decoding
            if (isset($data['smtp_credential'])) {
                $data = json_decode($data['smtp_credential'], true);
            } else {
                $data = [];
            }
 
            return response()->json(['data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function workingDays(Request $request)
    {
        try {
            $data = Setting::whereIn('key', ['working_days'])
                ->orderBy("id", "asc")
                ->pluck('value', 'key')
                ->toArray();
            foreach ($data as $key => $value) {
                if ($value === null) {
                    $data[$key] = '';
                }
            }
            if (isset($data['working_days'])) {
                $data = json_decode($data['working_days'], true);
            } else {
                $data = [];
            }
 
            return response()->json(['data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function workingTime(Request $request)
    {
        try {
            $setting = Setting::where('key', 'working_time')->first();
            $data = [
                'start_time' => '',
                'end_time' => ''
            ];
            if ($setting && $setting->value !== null) {
                $decodedData = json_decode($setting->value, true);
 
                $data['start_time'] = $decodedData['start_time'] ?? '';
                $data['end_time'] = $decodedData['end_time'] ?? '';
            }
            return response()->json(['data' => $data], 200);
        } catch (Exception $e) {
 
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function prefix(Request $request)
    {
        try {
            $data = Setting::whereIn('key', ['prefix'])->get();
            foreach ($data as $key => $value) {
                if ($value === null) {
                    $data[$key] = '';
                }
            }
            return response()->json(['data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
