<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\UserQuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use DB;

class LeaderboardController extends Controller{
    public function index(){
		$check_access = Gate::allows('check-access', ['TopScorers', 'View']);
		
		if ($check_access) {
			return view('modules.leaderboard.leaderboard');
		} else {
			abort(403, 'Unauthorized');
		}
    }
    

   /*  public function getLeaderboardData(Request $request){	
		$leaderboard = UserQuizAttempt::select(
				'user_id',
				DB::raw('MAX(total_attempt_question) as total_attempt_question'),
				DB::raw('MAX(total_questions) as total_questions'),
				DB::raw('MAX(started_at) as started_at'),
				DB::raw('MAX(finished_at) as finished_at'),
				DB::raw('MAX(score) as highest_score'),
				DB::raw('COUNT(id) as total_attempts')
			)
			->with('user:id,name')
			->where('status', 'completed')
			->groupBy('user_id')
			->orderByDesc('highest_score')
			->get();

		$rank = 1;
		$leaderboard->transform(function ($item) use (&$rank) {
			$item->rank = $rank++;
			return $item;
		});

		return response()->json([
			'status' => true,
			'data' => $leaderboard
		]);
    }  */
	
	public function getLeaderboardData(Request $request){	
		$leaderboard = UserQuizAttempt::select(
				'user_id',
				DB::raw('MAX(total_attempt_question) as total_attempt_question'),
				DB::raw('MAX(total_questions) as total_questions'),
				DB::raw('MAX(started_at) as started_at'),
				DB::raw('MAX(finished_at) as finished_at'),
				DB::raw('SUM(score) as total_score'),
				
				DB::raw('SUM(total_questions) as sum_total_questions'),
				DB::raw('SUM(score) as sum_score'),
				
				DB::raw('MAX(score) as highest_score'),
				DB::raw('MAX(quiz_id) as quiz_id'),
				DB::raw('COUNT(id) as total_attempts')
			)
			->with([
				'user:id,name',
				'quiz:id,quiz_title,quiz_image'  
			])
			->where('status', 'completed')
			->groupBy('user_id')
			->orderByDesc('sum_score')
			->get();

		$rank = 1;
		$leaderboard->transform(function ($item) use (&$rank) {
			$item->rank = $rank++;
			return $item;
		});

		return response()->json([
			'status' => true,
			'data' => $leaderboard
		]);
    }  
}