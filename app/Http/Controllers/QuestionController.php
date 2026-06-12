<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    private function syncTotalQuestions($quizId)
    {
        if (!$quizId) return;

        $count = Question::where('quiz_id', $quizId)->count();

        Quiz::where('id', $quizId)->update(['total_questions' => $count]);
    }

    public function index()
    {
        $check_access = Gate::allows('check-access', ['Question', 'View']);

        if ($check_access) {
            $quizzes = Quiz::where('status', 'Active')
                ->orderBy('quiz_title', 'asc')
                ->get();
            return view('modules.questions.add', compact('quizzes'));
        } else {
            abort(403, 'Unauthorized');
        }
    }

    public function getQuestions()
    {
        try {
            $questions = Question::with('quiz')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($questions);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch questions',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function addQuestionAjax(Request $request)
    {
        $rules = [
            'quiz_id'        => 'required',
            'question_text'  => 'required',
            'question_type'  => 'required',
            'option_1'       => 'required',
            'option_2'       => 'required',
            'option_3'       => 'required',
            'option_4'       => 'required',
            'correct_option' => 'required',
        ];

        if ($request->question_type == 'Multiple Choice') {
            $rules['option_3'] = 'required|string';
            $rules['option_4'] = 'required|string';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $option1       = trim($request->option_1);
        $option2       = trim($request->option_2);
        $option3       = trim($request->option_3);
        $option4       = trim($request->option_4);
        $correctOption = trim($request->correct_option);

        $correct_option_number = 0;
        if      ($correctOption === $option1) $correct_option_number = 1;
        elseif  ($correctOption === $option2) $correct_option_number = 2;
        elseif  ($correctOption === $option3) $correct_option_number = 3;
        elseif  ($correctOption === $option4) $correct_option_number = 4;

        try {
            $data = [
                'quiz_id'               => $request->quiz_id,
                'question_text'         => $request->question_text,
                'question_type'         => $request->question_type,
                'option_1'              => $request->option_1,
                'option_2'              => $request->option_2,
                'option_3'              => $request->option_3 ?? null,
                'option_4'              => $request->option_4 ?? null,
                'correct_option'        => $request->correct_option,
                'marks'                 => $request->marks ?? 1,
                'correct_option_number' => $correct_option_number,
            ];

            if ($request->filled('question_id')) {
                $question = Question::find($request->question_id);

                if (!$question) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Question not found'
                    ], 404);
                }

                $oldQuizId = $question->quiz_id; 
                $question->update($data);

                $this->syncTotalQuestions($oldQuizId);
                if ((int)$oldQuizId !== (int)$request->quiz_id) {
                    $this->syncTotalQuestions($request->quiz_id);
                }

                $message = 'Question updated successfully';

            } else {
                $question = Question::create($data);

                $this->syncTotalQuestions($request->quiz_id);

                $message = 'Question created successfully';
            }

            return response()->json([
                'status'  => true,
                'message' => $message,
                'data'    => $question
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to save question',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $question = Question::find($request->id);

        if (!$question) {
            return response()->json([
                'status'  => false,
                'message' => 'Question not found'
            ], 404);
        }

        $quizId = $question->quiz_id; 
        $question->delete();
        $this->syncTotalQuestions($quizId);

        return response()->json([
            'status'  => true,
            'message' => 'Question deleted successfully'
        ]);
    }
}