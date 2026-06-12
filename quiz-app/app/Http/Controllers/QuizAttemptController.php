<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\UserQuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator; 

class QuizAttemptController extends Controller{
    public function quizAttemptMonitoring(){
		$check_access = Gate::allows('check-access', ['Quiz', 'View']);
		
		if ($check_access) {
			return view('modules.quiz.attempt');
		} else {
			abort(403, 'Unauthorized');
		}
    }

    public function attemptMonitoringAjax(Request $request){
		$attempts = UserQuizAttempt::with([
				'user:id,name',
				'quiz:id,quiz_title'
			])->orderBy('id', 'desc')->get();

		if ($attempts->isNotEmpty()) {
			return response()->json([
				'status' => true,
				'data'   => $attempts
			], 200);
		} else {
			return response()->json([
				'status'  => false,
				'message' => 'No quiz attempts found'
			], 404);
		}
	}


}