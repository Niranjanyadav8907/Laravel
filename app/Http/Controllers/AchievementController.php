<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class AchievementController extends Controller
{
    public function achievement(){
		$check_access = Gate::allows('check-access', ['Achievement', 'View']);
		if ($check_access) {
			return view('modules.leaderboard.achievement');
		} else {
			abort(403, 'Unauthorized');
		}
    }

    public function getAchievements()
    {
        try {
            $achievements = Achievement::orderBy('created_at', 'desc')->get();
            return response()->json($achievements);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch achievements',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addAchievementAjax(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'required|string|max:100',
            'icon_bg_color' => 'required|string|max:50',
            'criteria_type' => 'required|in:quiz_completed,score_achieved,time_based,rank_based',
            'criteria_value' => 'required|integer|min:1',
            'status' => 'required|in:Active,Inactive',
            'achievement_id' => 'nullable|exists:achievements,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $achievement = $request->achievement_id 
                ? Achievement::find($request->achievement_id) 
                : new Achievement();

            if ($request->achievement_id && !$achievement) {
                return response()->json([
                    'status' => false,
                    'message' => 'Achievement not found'
                ], 404);
            }

            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'icon' => $request->icon,
                'icon_bg_color' => $request->icon_bg_color,
                'criteria_type' => $request->criteria_type,
                'criteria_value' => $request->criteria_value,
                'status' => $request->status,
            ];

            if (!$request->achievement_id) {
                $achievement = Achievement::create($data);
                $message = 'Achievement created successfully';
            } else {
                $achievement->update($data);
                $message = 'Achievement updated successfully';
            }

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $achievement
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteAchievement(Request $request)
    {
        $achievement = Achievement::find($request->id);

        if (!$achievement) {
            return response()->json([
                'status' => false,
                'message' => 'Achievement not found'
            ], 404);
        }

        $achievement->delete();

        return response()->json([
            'status' => true,
            'message' => 'Achievement deleted successfully'
        ]);
    }

    public function updateAchievementStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required|in:Active,Inactive'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $achievement = Achievement::find($request->id);
            $achievement->status = $request->status;
            $achievement->save();

            return response()->json([
                'status' => true,
                'message' => 'Achievement status updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
	
	public function achievementSync(Request $request){
		echo"hi achievementSync";
    }
}