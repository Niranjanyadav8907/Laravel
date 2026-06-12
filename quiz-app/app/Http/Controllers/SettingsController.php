<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Gate;

class SettingsController extends Controller{
	
    public function activityLog(){
		return view('modules.settings.activity_log');
    }
	
	public function addSettings(){
		return view('modules.settings.add');
    }
	
	public function addSettingsAjax(Request $request){
				
        $rules = [
			'setting_key'    => 'required|string|max:255',
			'value'          => 'required|string|max:255',
			'type'           => 'required|string|max:100',
			'setting_group'  => 'required|string|max:255',
			'label'          => 'required|string|max:255',
			'description'    => 'required|string|max:255',
			'is_public'      => 'required',
			'id'             => 'nullable|exists:settings,id'
		];

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return response()->json([
				'status'  => false,
				'errors'  => $validator->errors()
			], 422);
		}

		try {

			// Agar id hai → update
			if ($request->id) {
				$setting = Setting::find($request->id);

				if (!$setting) {
					return response()->json([
						'status' => false,
						'message' => 'Setting not found'
					]);
				}

			} 
			// warna insert
			else {
				$setting = new Setting();
				$setting->user_id = Auth::id();
			}

			// Common fields for insert + update
			$setting->setting_key   = $request->setting_key;
			$setting->value         = $request->value;
			$setting->type          = $request->type;
			$setting->setting_group = $request->setting_group;
			$setting->label         = $request->label;
			$setting->description   = $request->description;
			$setting->is_public     = $request->is_public;

			$setting->save();

			return response()->json([
				'status'  => true,
				'message' => $request->id 
					? 'Setting updated successfully' 
					: 'Setting added successfully',
				'data'    => $setting
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status'  => false,
				'message' => 'Server error',
				'error'   => $e->getMessage()
			], 500);
		}
    }
	
	public function getSettings(){
		$settings = Setting::orderBy('created_at', 'desc')->get();

		if ($settings) {
			return response()->json([
				'status' => true,
				'settings' => $settings,
			]);
		} else {
			return response()->json([
				'status' => false,
				'message' => 'Failed to fetch settings'
			], 500);
		}
	}
	
	public function delete(Request $request){   
        $setting = Setting::find($request->id);

        if (!$setting) {
            return response()->json([
                'status' => false,
                'message' => 'Setting not found'
            ], 404);
        }

        $setting->delete();

        return response()->json([
            'status' => true,
            'message' => 'Setting deleted successfully'
        ]);
    } 
	
	public function getActivityLog(Request $request){   
		try {
			$logs = ActivityLog::latest()->take(500)->get(); 

			return response()->json([
				'status' => true,
				'logs' => $logs
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status' => false,
				'message' => $e->getMessage()
			]);
		}
    } 
	

}