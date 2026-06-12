<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Category;
use App\Models\Question;
use App\Models\UserQuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Gate;

class QuizController extends Controller{
    public function addQuiz(){
		$check_access = Gate::allows('check-access', ['Quiz', 'View']);
		
		if ($check_access) {
			$categories = Category::where('status', 'active')->orderBy('name', 'asc')->get();
			return view('modules.quiz.add', compact('categories'));
		} else {
			abort(403, 'Unauthorized');
		}
    }
	
	public function getQuiz(){
		$quizzes = Quiz::with('category:id,name')
			->with('questions')
			->select(
				'id',
				'quiz_title',
				'quiz_description',
				'category_id',
				'difficulty',
				'total_questions',
				'status',
				'start_date',
				'end_date',
				'created_at',
				'updated_at',
				'timer',
				'quiz_image',
                'quiz_planner',
				'created_by'
			)
			->orderBy('created_at', 'desc')
			->get();

		$categories = Category::select('id','name')->orderBy('id', 'desc')->get();

		if ($quizzes && $categories) {
			return response()->json([
				'status' => true,
				'quizzes' => $quizzes,
				'categories' => $categories
			]);
		} else {
			return response()->json([
				'status' => false,
				'message' => 'Failed to fetch quizzes'
			], 500);
		}
	}

	/* public function getQuiz(){ 
		try { 
			$quizzes = Quiz::with('category:id,name')->with('questions')->select('id','quiz_title','quiz_description','category_id','difficulty','total_questions','status','start_date','end_date','created_at','updated_at','timer','quiz_image','created_by')->orderBy('created_at', 'desc')->get();
			
			$category = Category::orderby('id' , 'desc')->get();

			return response()->json($quizzes);
		} catch (\Exception $e) {
			return response()->json([
				'status' => false,
				'message' => 'Failed to fetch quizzes',
				'error' => $e->getMessage()
			], 500);
		}
	} */

    public function updateDifficulty(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'difficulty' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $quiz = Quiz::find($request->id);
            $quiz->difficulty = $request->difficulty;
            $quiz->save();

            return response()->json([
                'status' => true,
                'message' => 'Quiz difficulty updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update difficulty',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $quiz = Quiz::find($request->id);
            $quiz->status = $request->status;
            $quiz->save();

            return response()->json([
                'status' => true,
                'message' => 'Quiz status updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addQuizAjax(Request $request){
        $rules = [
            'quiz_title'        => 'required|string|max:255',
            'quiz_description'  => 'nullable|string',
            'category_id'       => 'required|exists:categories,id',
            'difficulty'        => 'required|in:Easy,Medium,Hard',
            'status'            => 'required|in:Draft,Active,Inactive',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after:start_date',
            'timer'             => 'required|integer|min:1',
            'quiz_id'           => 'nullable|exists:quiz,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

		$category = Category::firstOrCreate(
			['name' => $request->category_input] 
		);
		$category_id = $category->id;
		
        try {
            $quiz = $request->quiz_id ? Quiz::find($request->quiz_id) : new Quiz();

            if ($request->quiz_id && !$quiz) {
                return response()->json([
                    'status' => false,
                    'message' => 'Quiz not found'
                ], 404);
            }

            $data = [
                'quiz_title'       => $request->quiz_title,
                'quiz_description' => $request->quiz_description,
                //'category_id'      => $request->category_id,
                'category_id'      => $category_id,
                'difficulty'       => $request->difficulty,
                'total_questions'  => $request->total_questions,
                'status'           => $request->status,
                'start_date'       => $request->start_date,
                'end_date'         => $request->end_date,
                'timer'            => $request->timer,
            ];

            if ($request->hasFile('quiz_image')) {

                if (!empty($quiz->quiz_image)) {
                    $oldPath = public_path('assets/images/quiz_images/' . $quiz->quiz_image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $image     = $request->file('quiz_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $image->move(
                    public_path('assets/images/quiz_images'),
                    $imageName
                );

                $data['quiz_image'] = $imageName;
            }

            if (!$request->quiz_id) {
                $data['created_by'] = Auth::id();
                $quiz = Quiz::create($data);
                $message = 'Quiz created successfully';
            }else {
                $quiz->update($data);
                $message = 'Quiz updated successfully';
            }

            return response()->json([
                'status'  => true,
                'message' => $message,
                'data'    => $quiz
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request){   
        $quiz = Quiz::find($request->id);

        if (!$quiz) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz not found'
            ], 404);
        }

        $quiz->delete();

        return response()->json([
            'status' => true,
            'message' => 'Quiz deleted successfully'
        ]);
    }
    
    public function getQuizForUser(Request $request){
        $keywords = $request->keywords;
        $difficulty = $request->difficulty;
        $total_questions = $request->question;
        $id = $request->id;
    
        if ($id) {
            $quiz = Quiz::where('id', $id)->first();
			$already_attempted = UserQuizAttempt::where('quiz_id', $id)->where('user_id', auth()->id())->exists();
			$quiz_attempted = UserQuizAttempt::where('quiz_id', $id)->where('user_id', auth()->id())->first();
			
			$quiz_attempt_status = null;
			if ($quiz_attempted) {
				$quiz_attempt_status = $quiz_attempted->status;
			}

            if (!$quiz) {
                return response()->json([
                    'status' => false,
                    'message' => 'Quiz coming soon'
                ]);
            }

            $questions = Question::where('quiz_id', $id)->get();

            return response()->json([
                'status' => true,
                'data' => $quiz,
                'questions' => $questions,
                'attemoted' => $already_attempted,
                'quiz_attempt_status' => $quiz_attempt_status
            ]);
        }
    
        $quizzes = Quiz::with('questions')->select('id', 'timer', 'quiz_image', 'quiz_title', 'quiz_description', 'difficulty', 'total_questions', 'start_date', 'end_date')
            ->when($keywords, function ($query) use ($keywords) {
                $query->where('quiz_title', 'LIKE', '%' . $keywords . '%');
            })
            ->when($difficulty, function ($query) use ($difficulty) {
                $query->where('difficulty', 'LIKE', '%' . $difficulty . '%');
            })
            ->when($total_questions, function ($query) use ($total_questions) {
                $query->where('total_questions', 'LIKE', '%' . $total_questions . '%');
            })
            ->where('status', 'Active')
            ->get();
    
        return response()->json([
            'status' => true,
            'data' => $quizzes
        ]);
    }

    public function quizStatusUpdate(Request $request){
        $request->validate([
            'id' => 'required',
            'status' => 'required',
        ]);

        try {
            $quiz = Quiz::findOrFail($request->id);
            $quiz->status = $request->status;
            $quiz->save();

            return response()->json([
                'status' => true,
                'message' => 'Quiz status updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function difficultyStatusUpdate(Request $request){
        $request->validate([
            'id' => 'required',
            'difficulty' => 'required',
        ]);

        try {
            $quiz = Quiz::findOrFail($request->id);
            $quiz->difficulty = $request->difficulty;
            $quiz->save();

            return response()->json([
                'status' => true,
                'message' => 'Quiz difficulty updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }
	
	public function winnerAnnouncement(){
        return view('winner');
    }
	
	public function addQuizCategory(){
		$check_access = Gate::allows('check-access', ['QuizCategory', 'View']);
		
		if ($check_access) {
			return view('modules.quiz.category.add');
		} else {
			abort(403, 'Unauthorized');
		}
    }
	
	public function getQuizCategory(){
		$categories = Category::with('quizzes')->select('id', 'name', 'description', 'status')->orderBy('id', 'desc')->get();

		if ($categories->isNotEmpty()) {
			return response()->json([
				'status' => true,
				'data' => $categories
			]);
		} else {
			return response()->json([
				'status' => false,
				'message' => 'No categories found'
			]);
		}
	} 
	
	/*public function getQuizCategory(){
		$categories = Category::whereHas('quizzes', function ($query) {
				$query->whereNotNull('total_questions')
					  ->where('total_questions', '>', 0);
			})
			->with(['quizzes' => function ($query) {
				$query->whereNotNull('total_questions')
					  ->where('total_questions', '>', 0);
			}])
			->select('id', 'name', 'description', 'status')
			->orderBy('id', 'desc')
			->get();

		if ($categories->isNotEmpty()) {
			return response()->json([
				'status' => true,
				'data' => $categories
			]);
		} else {
			return response()->json([
				'status' => false,
				'message' => 'No categories found'
			]);
		}
	}*/
	
	public function addCategoryAjax(Request $request){

		$rules = [
			'category_title' => 'required|string|max:255',
		];

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return response()->json([
				'status'  => false,
				'message' => 'Validation Error',
				'errors'  => $validator->errors()
			], 422);
		}

		if (!empty($request->quiz_category_id)) {

			$category = Category::find($request->quiz_category_id);

			if ($category) {

				$category->name = $request->category_title;
				$category->description = $request->description;
				$category->save();

				return response()->json([
					'status' => true,
					'message' => 'Category updated successfully',
					'data' => $category
				]);

			} else {
				return response()->json([
					'status' => false,
					'message' => 'Category not found'
				], 404);
			}

		} else {

			$category = new Category();
			$category->name = $request->category_title;
			$category->description = $request->description;
			$category->save();

			return response()->json([
				'status' => true,
				'message' => 'Category added successfully',
				'data' => $category
			]);
		}
	}
	
	public function deleteCategory(Request $request){
		if (empty($request->id)) {
			return response()->json([
				'status' => false,
				'message' => 'Category ID is required'
			], 422);
		}

		$category = Category::find($request->id);

		if (!$category) {
			return response()->json([
				'status' => false,
				'message' => 'Category not found'
			], 404);
		}

		$category->delete();

		return response()->json([
			'status' => true,
			'message' => 'Category deleted successfully'
		]);
	}
    //=========== schedule Quiz  ==================
    public function schedule(){
		$check_access = Gate::allows('check-access', ['QuizSchedule', 'View']);
		
		if ($check_access) {
			return view('modules.quiz.schedule');
		} else {
			abort(403, 'Unauthorized');
		}
    }

    public function getScheduleData()
    {
        try {
            $quizzes = Quiz::select('id', 'quiz_title', 'quiz_description', 'quiz_image', 'schedule', 'quiz_planner', 'quiz_controls')
                ->where('status', 'Active')
                ->orderBy('quiz_planner', 'asc')
                ->get();

            return response()->json($quizzes);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch schedule data',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function updateQuizPlanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:quiz,id',
            'quiz_planner' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $quiz = Quiz::find($request->id);
            
            if (!$quiz) {
                return response()->json([
                    'status' => false,
                    'message' => 'Quiz not found'
                ], 404);
            }

            $quiz->quiz_planner = $request->quiz_planner;
            $quiz->save();

            $message = $request->quiz_planner ? 'Quiz date updated successfully' : 'Quiz date cleared successfully';

            return response()->json([
                'status' => true,
                'message' => $message
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update quiz date',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function updateScheduleType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:quiz,id',
            'schedule' => 'required|in:one-time,recurring',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $quiz = Quiz::find($request->id);
            
            if (!$quiz) {
                return response()->json([
                    'status' => false,
                    'message' => 'Quiz not found'
                ], 404);
            }

            $quiz->schedule = $request->schedule;
            $quiz->save();

            return response()->json([
                'status' => true,
                'message' => 'Schedule type updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update schedule type',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function updateQuizControl(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:quiz,id',
            'quiz_controls' => 'nullable|in:pause,reschedule,cancel',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $quiz = Quiz::find($request->id);
            
            if (!$quiz) {
                return response()->json([
                    'status' => false,
                    'message' => 'Quiz not found'
                ], 404);
            }

            $quiz->quiz_controls = $request->quiz_controls;
            
            // If cancelled, update status to inactive
            if ($request->quiz_controls == 'cancel') {
                $quiz->status = 'Inactive';
            }
            
            $quiz->save();

            $message = $request->quiz_controls ? 
                    'Quiz ' . $request->quiz_controls . 'd successfully' : 
                    'Quiz activated successfully';

            return response()->json([
                'status' => true,
                'message' => $message
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update quiz control',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}