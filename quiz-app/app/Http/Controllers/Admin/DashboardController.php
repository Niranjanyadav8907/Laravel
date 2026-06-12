<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
	
	public function adminDashboard(){
		$user = auth()->user();

		if (!$user) {
			return redirect()->route('showLogin');
		} 
		$logged_user = User::find($user->id);
		
		if($logged_user->role == 1 || $logged_user->role == 2){
			return view('admin.dashboard');
		}else if($logged_user->role == 3){
			return view('user.dashboard');
		}else if($logged_user->role == 4){
			return redirect()->route('welcome')->with('success', 'User Access Granted!');
		}else{
			return redirect()->route('welcome')->with('success', 'User Access Granted!');
		}
		
	}
	public function dashboardContent(Request $request)
    {
		$id = $request->id;
		$date = $request->date;

		$roleCounts = User::join('role', 'users.role', '=', 'role.id')
			->select('role.role_slug', DB::raw('COUNT(users.id) as total'))
			->groupBy('role.role_slug')
			->get();

		$statusCounts = User::select('status', DB::raw('COUNT(*) as total'))
			->groupBy('status')
			->get();

		$totalRoles = DB::table('role')->count();
		$totalQuizs = DB::table('quiz')->count();
		$totalQuizAttempts = DB::table('user_quiz_attempts')->count();
		$totalQuestions = DB::table('questions')->count();
		$topScorers = DB::table('user_quiz_attempts as qa')
			->select(
				'users.name',
				'users.image',
				DB::raw('MAX(qa.score) as highest_score')
			)
			->join('users', 'users.id', '=', 'qa.user_id')
			->groupBy('qa.user_id', 'users.name' , 'users.image')
			->orderByDesc('highest_score')
			->limit(5)
			->get();
		$topScorersCount = $topScorers->count();

		$activePlans = DB::table('subscription')
			->where('status', 'Active')
			->select('plan_name', 'price', 'duration')
			->get();

		$activePlansCount = $activePlans->count();


		return response()->json([
			'status' => true,
			'role_counts' => $roleCounts,
			'status_counts' => $statusCounts,
			'total_roles' => $totalRoles,
			'total_quizs' => $totalQuizs,
			'total_quiz_attempts' => $totalQuizAttempts,
			'total_questions' => $totalQuestions,
			'top_scorers' => $topScorers,
			'top_scorers_count' => $topScorersCount,

			'active_plans' => $activePlans,
            'active_plans_count' => $activePlansCount,

		]);
    }

}