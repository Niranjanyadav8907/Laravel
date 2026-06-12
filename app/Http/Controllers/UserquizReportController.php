<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserQuizAttempt;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserquizReportController extends Controller
{
    public function index()
    {
        return view('modules.users.userquiz_report');
    }

    /**
     * AJAX: All users quiz report (aggregated per user)
     */
    public function reportData()
    {
        $users = User::all();

        $data = $users->map(function ($user) {
            $attempts = DB::table('user_quiz_attempts')
                ->where('user_id', $user->id)
                ->get();

            if ($attempts->isEmpty()) {
                return null;
            }

            $totalAttempts = $attempts->count();
            $highestScore  = $attempts->max('score') ?? 0;
            $avgScore      = round($attempts->avg('score') ?? 0, 2);
            $totalPoints   = $attempts->sum('score') ?? 0;
            $startedAt     = $attempts->min('started_at');
            $finishedAt    = $attempts->max('finished_at');

            $totalQ   = $attempts->sum('total_questions');
            $totalObt = $attempts->sum('score');
            $percent  = $totalQ > 0 ? round(($totalObt / $totalQ) * 100, 2) : 0;

            return [
                'user_id'       => $user->id,
                'name'          => $user->name,
                'email'         => $user->email,
                'quiz_attempts' => $totalAttempts,
                'started_at'    => $startedAt  ? \Carbon\Carbon::parse($startedAt)->format('d M Y, h:i A')  : '-',
                'finished_at'   => $finishedAt ? \Carbon\Carbon::parse($finishedAt)->format('d M Y, h:i A') : '-',
                'highest_score' => $highestScore,
                'avg_score'     => $avgScore,
                'total_points'  => $totalPoints,
                'status'        => $percent >= 60 ? 'Qualified' : 'Not Qualified',
            ];
        })->filter()->values();

        return response()->json([
            'status' => true,
            'data'   => $data,
        ]);
    }

    /**
     * AJAX: Single user result detail (modal)
     */
    public function userResult($userId)
    {
        $user     = User::find($userId);
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
        $level     = $percentage >= 80 ? 'Advanced' : ($percentage >= 60 ? 'Intermediate' : 'Beginner');

        // ✅ User image URL
        $userImage = null;
        if ($user && $user->image) {
            $userImage = asset('assets/images/profile_images/' . $user->image);
        }

        return response()->json([
            'status'         => true,
            'user_name'      => $user->name ?? 'N/A',
            'user_email'     => $user->email ?? 'N/A',
            'user_image'     => $userImage, // ✅ added
            'total_obtained' => $totalObtained,
            'total_possible' => $totalPossible,
            'percentage'     => $percentage,
            'qualified'      => $qualified,
            'performance'    => $level,
            'attempts'       => $attempts->map(function ($item) {
                return [
                    'quiz_title' => $item->quiz_title ?? 'N/A',
                    'category'   => $item->category_name ?? 'General',
                    'score'      => $item->score,
                    'total'      => $item->total_questions,
                    'date'       => $item->finished_at
                                    ? \Carbon\Carbon::parse($item->finished_at)->format('d M Y')
                                    : '-',
                ];
            })->values(),
        ]);
    }

    /**
     * AJAX: Single user quiz history detail (modal)
     */
    public function userQuizHistory($userId)
    {
        $user     = User::find($userId);
        $attempts = DB::table('user_quiz_attempts as qa')
            ->leftJoin('quiz', 'quiz.id', '=', 'qa.quiz_id')
            ->where('qa.user_id', $userId)
            ->select(
                'qa.id',
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
                    'id'         => $item->id,
                    'quiz_name'  => $item->quiz_name ?? 'N/A',
                    'score'      => $item->score ?? 0,
                    'attempted'  => $item->total_attempt_question ?? 0,
                    'total'      => $item->total_questions ?? 0,
                    'started_at' => $item->started_at
                                    ? \Carbon\Carbon::parse($item->started_at)->format('d M Y, h:i A')
                                    : '-',
                    'finished_at'=> $item->finished_at
                                    ? \Carbon\Carbon::parse($item->finished_at)->format('d M Y, h:i A')
                                    : '-',
                    'status'     => $item->status ?? '-',
                    'message'    => $item->message ?? '-',
                ];
            });

        return response()->json([
            'status'    => true,
            'user_name' => $user->name ?? 'N/A',
            'data'      => $attempts,
        ]);
    }
}