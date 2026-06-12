<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserQuizAttempt;
use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;    
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; 

class UsersController extends Controller{
	
	public function all(){
		$check_access = Gate::allows('check-access', ['User', 'View']);
		
		if ($check_access) {
			return view('modules.users.all');
		} else {
			abort(403, 'Unauthorized');
		}
	}
	
	public function add(){
		$check_access = Gate::allows('check-access', ['User', 'Add']);
		
		if ($check_access) {
			return view('modules.users.add');
		} else {
			abort(403, 'Unauthorized');
		}
	}
	
	public function getUsers(){
        $users = User::orderBy('id', 'desc')->get(); 
        return response()->json($users);
    }
	
	
	public function edit($id){
		$check_access = Gate::allows('check-access', ['User', 'Update']);
		
		if ($check_access) {
			$user = User::findOrFail($id);
			return view('modules.users.edit', compact('user'));
		} else {
			abort(403, 'Unauthorized');
		}
    }
	
	public function delete(Request $request){
		$check_access = Gate::allows('check-access', ['User', 'Delete']);
		
		if ($check_access) {
			$user = User::find($request->id);

			if (!$user) {
				return response()->json([
					'status' => false,
					'message' => 'User not found'
				], 404);
			}
			$user->delete();

			return response()->json([
				'status' => true,
				'message' => 'User delete successfully'
			]);
		} else {
			abort(403, 'Unauthorized');
		}
    }
	
	public function startAtamptQuizByUser(Request $request){
		
		$quiz = new UserQuizAttempt();
		$quiz->user_id =  auth()->id();
		$quiz->quiz_id =  $request->quiz_id;
		$quiz->score =  0;
		$quiz->started_at =  now();
		$quiz->finished_at =  now();
		$quiz->status =  'pending';
		$quiz->message =  'quiz started';
		$quiz_save = $quiz->save();
		
		if($quiz_save){
			return response()->json([
				'status'  => 'success',
				'message' => 'Quiz successfully saved 🎉',
				'quiz'   => $quiz_save
			]);
		}
		
		return response()->json([
			'status'  => 'error',
			'message' => 'Quiz saved failed'
		], 401);
	}

	public function submitQuizByUser(Request $request){
		$userId = auth()->id();

		if (!$userId) {
			return response()->json([
				'status'  => 'error',
				'message' => 'Unauthorized user'
			], 401);
		}

		$quizId  = $request->id;
		$answers = $request->parsedValue;
		
		$attempt = UserQuizAttempt::where('quiz_id', $quizId)->where('user_id', $userId)->first();

		if ($attempt) {
			$attempt->finished_at = now();
			$attempt->score       = 0;
			$attempt->status      = 'completed';
			$attempt->message      = $request->message;
			$attempt->save();
		}else{
			$attempt = UserQuizAttempt::create([
				'user_id'     => $userId,
				'quiz_id'     => $quizId,
				'finished_at' => now(),
				'score'       => 0,
				'message'       => $request->message,
				'status'       => 'completed'
			]);
		}
		
		if (!$quizId || empty($answers)) {
			
			UserAnswer::create([
				'attempt_id'      => $attempt->id,
				'question_id'     => 0,
				'selected_option' => 0,
				'is_correct'      => 0,
				'answered_at'     => now()
			]);
			
			return response()->json([
				'status'  => 'success',
				'message' => 'Quiz successfully submitted 🎉',
				'score'   => ''
			]);
			
		}

		$score = 0;
		$addedQuestions = [];

		foreach ($answers as $answer) {

			if (!isset($answer['question_id'], $answer['selected_option'])) {
				continue;
			}

			$questionId = $answer['question_id'];

			if (in_array($questionId, $addedQuestions)) {
				continue;
			}
			$addedQuestions[] = $questionId;

			$question = Question::find($questionId);
			
			if (!$question) continue;

			$isCorrect = ($answer['selected_option'] == $question->correct_option_number) ? 1 : 0;

			if ($isCorrect) {
				$score += (int) $question->marks;
			}

			UserAnswer::create([
				'attempt_id'      => $attempt->id,
				'question_id'     => $questionId,
				'selected_option' => $answer['selected_option'],
				'is_correct'      => $isCorrect,
				'answered_at'     => now()
			]);
		}
		
		$total_attempt_question = UserAnswer::where('attempt_id', $attempt->id)->count();
		$total_questions = Question::where('quiz_id', $attempt->quiz_id)->count();

		$attempt->update([
			'score'       => $score,
			'total_attempt_question'       => $total_attempt_question,
			'total_questions'       => $total_questions,
			'finished_at'=> now()
		]); 

		return response()->json([
			'status'  => 'success',
			'message' => 'Quiz successfully submitted 🎉',
			'score'   => $score
		]);
    }
    
	public function atamptQuizByUser(Request $request){
		echo'<pre>';
		print_r($_POST);
    }
	 
	public function startQuiz($id){ 
		return view('modules.quiz.quiz_start', ['id' => $id]);
    }

	//============================== profile =========================================
		
	public function profile(){
		return view('modules.users.profile');
	}

	public function userProfile(){
		return view('modules.users.user_profile');
	}

	public function updateProfile(Request $request){
		$user = auth()->user();

		$validator = Validator::make($request->all(), [
			'name'         => 'required|string|max:255',
			'phone_number' => 'nullable|string|max:20',
			'about'        => 'nullable|string|max:1000',
			'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
			'old_password' => 'nullable|string',
			'new_password' => 'nullable|string|min:8|confirmed',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status'  => false,
				'message' => 'Validation Error',
				'errors'  => $validator->errors()
			], 422);
		}

		try {
		
			$user->name         = $request->name;
			$user->phone_number = $request->phone_number;
			$user->about        = $request->about;

			if ($request->filled('old_password') && $request->filled('new_password')) {
				if (!Hash::check($request->old_password, $user->password)) {
					return response()->json([
						'status'  => false,
						'message' => 'Validation Error',
						'errors'  => ['old_password' => ['Old password is incorrect.']]
					], 422);
				}
				$user->password = Hash::make($request->new_password);
			}

			if ($request->hasFile('image')) {
				if (!empty($user->image)) {
					$oldPath = public_path('assets/images/profile_images/' . $user->image);
					if (file_exists($oldPath)) {
						unlink($oldPath);
					}
				}

				$image     = $request->file('image');
				$imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

				$image->move(
					public_path('assets/images/profile_images'),
					$imageName
				);

				$user->image = $imageName;
			}

			$user->save();

			return response()->json([
				'status'  => true,
				'message' => 'Profile updated successfully!',
				'data'    => $user
			], 200);

		} catch (\Exception $e) {
			return response()->json([
				'status'  => false,
				'message' => 'Failed to update profile: ' . $e->getMessage()
			], 500);
		}
	}

	public function removeProfileImage(){
		$user = auth()->user();

		try {
			if ($user->image) {
				$imagePath = public_path('assets/images/profile_images/' . $user->image);
				if (file_exists($imagePath)) {
					unlink($imagePath);
				}
				$user->image = null;
				$user->save();

				return response()->json([
					'status'  => true,
					'message' => 'Profile image removed successfully!'
				], 200);
			}

			return response()->json([
				'status'  => false,
				'message' => 'No profile image to remove.'
			], 400);

		} catch (\Exception $e) {
			return response()->json([
				'status'  => false,
				'message' => 'Failed to remove profile image: ' . $e->getMessage()
			], 500);
		}
	}

// ======================== User Dashboard ========================

public function userDashboard()
{
    return view('user.dashboard');
}

public function userDashboardData()
{
    $userId = auth()->id();

    $totalAttempts = UserQuizAttempt::where('user_id', $userId)->count();

    $averageScore = UserQuizAttempt::where('user_id', $userId)->avg('score');

    $highestScore = UserQuizAttempt::where('user_id', $userId)->max('score');

    $totalPoints = UserQuizAttempt::where('user_id', $userId)->sum('score');

    return response()->json([
        'status'        => true,
        'total_attempts' => $totalAttempts ?? 0,
        'average_score'  => round($averageScore ?? 0, 2),
        'highest_score'  => $highestScore ?? 0,
        'total_points'   => $totalPoints ?? 0,
    ]);
}
//========================================== User Quiz History Page=====================================================
public function quizHistory()
{
    return view('modules.users.quiz_history');
}

public function quizHistoryData()
{
    $userId = auth()->id();

    $attempts = DB::table('user_quiz_attempts as qa')
        ->leftJoin('quiz', 'quiz.id', '=', 'qa.quiz_id')
        ->where('qa.user_id', $userId)
        ->select(
            'qa.id',
            'qa.quiz_id',
            'qa.score',
            'qa.total_attempt_question',
            'qa.total_questions',
            'qa.started_at',
            'qa.finished_at',
            'qa.status',
            'qa.message',
            'quiz.quiz_title as quiz_name'
        )
        ->orderBy('qa.id', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'id'                     => $item->id,
                'quiz_id'                => $item->quiz_id,
                'quiz_name'              => $item->quiz_name ?? 'N/A',
                'score'                  => $item->score ?? 0,
                'total_attempt_question' => $item->total_attempt_question ?? 0,
                'total_questions'        => $item->total_questions ?? 0,
                'started_at'             => $item->started_at
                                            ? \Carbon\Carbon::parse($item->started_at)->format('d M Y, h:i A')
                                            : '-',
                'finished_at'            => $item->finished_at
                                            ? \Carbon\Carbon::parse($item->finished_at)->format('d M Y, h:i A')
                                            : '-',
                'status'                 => $item->status ?? '-',
                'message'                => $item->message ?? '-',
            ];
        });

    return response()->json([
        'status' => true,
        'data'   => $attempts,
    ]);
}

public function quizHistoryDetail($attemptId)
{
    $userId = auth()->id();

    $attempt = DB::table('user_quiz_attempts as qa')
        ->leftJoin('quiz', 'quiz.id', '=', 'qa.quiz_id')
        ->where('qa.id', $attemptId)
        ->where('qa.user_id', $userId)
        ->select(
            'qa.id',
            'qa.quiz_id',
            'qa.score',
            'quiz.quiz_title as quiz_name'
        )
        ->first();

    if (!$attempt) {
        return response()->json([
            'status'  => false,
            'message' => 'Attempt not found'
        ], 404);
    }

    $answers = UserAnswer::where('attempt_id', $attemptId)
        ->with('question')
        ->get()
        ->map(function ($ans) {
            return [
                'question'        => $ans->question->question_text ?? 'N/A',
                'selected_option' => $ans->selected_option,
                'correct_option'  => $ans->question->correct_option_number ?? null,
                'is_correct'      => $ans->is_correct,
                'marks'           => $ans->question->marks ?? 0,
            ];
        });

    $correct   = $answers->where('is_correct', 1)->count();
    $incorrect = $answers->where('is_correct', 0)->count();

    return response()->json([
        'status'    => true,
        'quiz_name' => $attempt->quiz_name ?? 'N/A',
        'score'     => $attempt->score,
        'correct'   => $correct,
        'incorrect' => $incorrect,
        'answers'   => $answers,
    ]);
}

//============================== User Result Page=========================
public function myResult()
{
    return view('modules.users.results');
}

public function myResultData()
{
    $userId = auth()->id();
    $user   = User::find($userId);
    $attempts = DB::table('user_quiz_attempts as qa')
        ->leftJoin('quiz', 'quiz.id', '=', 'qa.quiz_id')
        ->leftJoin('categories', 'categories.id', '=', 'quiz.category_id')
        ->where('qa.user_id', $userId)
        ->where('qa.status', 'completed')
        ->select(
            'qa.id',
            'qa.score',
            'qa.total_questions',
            'qa.finished_at',
            'quiz.quiz_title',
            'categories.name as category_name'
        )
        ->orderBy('qa.id', 'desc')
        ->get();

    $totalObtained = $attempts->sum('score');
    $totalPossible = $attempts->sum('total_questions');
    $percentage    = $totalPossible > 0
                     ? round(($totalObtained / $totalPossible) * 100, 2)
                     : 0;

    $qualified = $percentage >= 60;
    $sectionWise = $attempts->groupBy('category_name')->map(function ($group, $catName) {
        $obtained  = $group->sum('score');
        $possible  = $group->sum('total_questions');
        $catPercent = $possible > 0 ? round(($obtained / $possible) * 100, 2) : 0;
        return [
            'category'   => $catName ?? 'General',
            'obtained'   => $obtained,
            'possible'   => $possible,
            'percentage' => $catPercent,
            'quizzes'    => $group->map(function ($item) {
                return [
                    'quiz_title' => $item->quiz_title ?? 'N/A',
                    'score'      => $item->score,
                    'total'      => $item->total_questions,
                    'date'       => $item->finished_at
                                    ? \Carbon\Carbon::parse($item->finished_at)->format('d M Y')
                                    : '-',
                ];
            })->values()
        ];
    })->values();
    $level = 'Beginner';
    if ($percentage >= 80) {
        $level = 'Advanced';
    } elseif ($percentage >= 60) {
        $level = 'Intermediate';
    }

    $latestAttempt = $attempts->first();
    $examDate = $latestAttempt
                ? \Carbon\Carbon::parse($latestAttempt->finished_at)->format('d M Y')
                : '-';

    return response()->json([
        'status'          => true,
        'user_name'       => $user->name ?? 'N/A',
        'user_email'      => $user->email ?? 'N/A',
        'exam_date'       => $examDate,
        'total_obtained'  => $totalObtained,
        'total_possible'  => $totalPossible,
        'percentage'      => $percentage,
        'qualified'       => $qualified,
        'performance'     => $level,
        'section_wise'    => $sectionWise,
    ]);
}

//==================================================
public function userAchievements()
{
    return view('modules.users.achievements');
}
}
