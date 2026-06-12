<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\AccessablityController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentController;



/*
|--------------------------------------------------------------------------
| Root Redirect - Auto redirect to login or dashboard
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::get('/register', [AuthController::class, 'showRegistration'])->name('showRegistration');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'ajaxRegister'])->name('ajax.register');
Route::post('/login', [AuthController::class, 'ajaxLogin'])->name('ajax.login');
Route::get('/admin-dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
Route::post('/dashboard-content', [DashboardController::class, 'dashboardContent'])->name('dashboard.content'); 


Route::middleware(['role'])->group(function () {
	Route::prefix('user')->group(function () {
		Route::get('/', [UsersController::class, 'all'])->name('users');
		Route::get('/add', [UsersController::class, 'add'])->name('add.user');
		Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('edit.user');
		Route::post('/delete', [UsersController::class, 'delete'])->name('users.delete');

		Route::prefix('ajax')->group(function () {
			Route::get('/', [UsersController::class, 'getUsers'])->name('users.data'); 
		});
	});

	Route::prefix('role')->group(function () {
		Route::get('/', [RolesController::class, 'allRole'])->name('all.role');
		Route::post('/delete', [RolesController::class, 'delete'])->name('role.delete');

		Route::prefix('ajax')->group(function () {
			Route::get('/', [RolesController::class, 'getRoles'])->name('role.data'); 
			Route::post('/add', [RolesController::class, 'addRoleAjax'])->name('add.role.ajax'); 
			Route::post('/update-status', [RolesController::class, 'roleStatusUpdate'])->name('role.status.update'); 
		});
	}); 
	
	Route::prefix('accessablity')->group(function () {
		Route::get('/add', [AccessablityController::class, 'addAccessablity'])->name('add.accessibility');
		Route::post('/add-role-for-accessablity', [AccessablityController::class, 'getRolesForAccessablitySave'])->name('get.role.for.assessablity.save');
		Route::post('get-role-access', [AccessablityController::class, 'getRolesForAccess'])->name('get.role.for.assessablity.save');
		Route::post('save-access', [AccessablityController::class, 'saveAccess'])->name('save.accessibility');
	});

});

Route::prefix('quiz/')->group(function () { 
	Route::get('/add', [QuizController::class, 'addQuiz'])->name('add.quiz');
	Route::post('/delete', [QuizController::class, 'delete'])->name('quiz.delete');
	Route::post('/save', [QuizController::class, 'save'])->name('quiz.save');

	Route::post('/update-quiz-status', [QuizController::class, 'quizStatusUpdate'])->name('update.status');  
	Route::post('/update-quiz-difficulty', [QuizController::class, 'difficultyStatusUpdate'])->name('difficulty.status.update'); 
	Route::prefix('ajax')->group(function () {
		Route::get('/', [QuizController::class, 'getQuiz'])->name('quiz.data'); 
		Route::post('/add', [QuizController::class, 'addQuizAjax'])->name('add.quiz.ajax'); 
		Route::post('/get-quiz', [QuizController::class, 'getQuizForUser'])->name('quiz.data.for.user'); 
	});
});

Route::prefix('question/')->group(function () { 
    Route::get('/add', [QuestionController::class, 'index'])->name('add.question');
    Route::post('/delete', [QuestionController::class, 'delete'])->name('question.delete');
    
    Route::prefix('ajax')->group(function () {
        Route::get('/', [QuestionController::class, 'getQuestions'])->name('questions.data'); 
        Route::post('/add', [QuestionController::class, 'addQuestionAjax'])->name('add.question.ajax'); 
    });
});


 Route::prefix('quiz-attempt-monitoring')->group(function () {
    Route::get('/', [QuizAttemptController::class, 'quizAttemptMonitoring'])->name('quiz-attempt-monitoring');

    Route::prefix('ajax')->group(function () {
        Route::get('/get-attempt-monitoring', [QuizAttemptController::class, 'attemptMonitoringAjax'])->name('quiz.attempt.data.for.user');
    });
});


Route::get('/', [AuthController::class, 'welcome'])->name('welcome');
Route::post('atampt-quiz', [UsersController::class, 'atamptQuizByUser'])->name('start.quiz.by.user');

Route::post('submit-attempt-quiz', [UsersController::class, 'submitQuizByUser'])->name('submit.quiz.by.user');
Route::post('start-attempt-quiz', [UsersController::class, 'startAtamptQuizByUser'])->name('attempt.quiz.by.user');
Route::get('/{id}/start-quiz', [UsersController::class, 'startQuiz'])->name('start.quiz');


Route::get('/winner-announcement', [QuizController::class, 'winnerAnnouncement'])->name('winner.announcement');

// Leaderboard Routes
Route::prefix('leaderboard')->group(function () {
    Route::get('/', [LeaderboardController::class, 'index'])->name('leaderboard');
    Route::get('/data', [LeaderboardController::class, 'getLeaderboardData'])->name('leaderboard.data');
});

Route::get('/achievement', [AchievementController::class, 'achievement'])->name('achievement');
Route::get('/achievement/data', [AchievementController::class, 'getAchievements'])->name('achievement.data');
Route::post('/achievement/add', [AchievementController::class, 'addAchievementAjax'])->name('add.achievement.ajax');
Route::post('/achievement/delete', [AchievementController::class, 'deleteAchievement'])->name('achievement.delete');
Route::post('/achievement/update-status', [AchievementController::class, 'updateAchievementStatus'])->name('achievement.update.status');

// Subscription Routes
Route::get('/subscription', [SubscriptionController::class, 'subscription'])->name('subscription');
Route::get('/subscription/data', [SubscriptionController::class, 'getSubscriptions'])->name('subscription.data');
Route::post('/subscription/add', [SubscriptionController::class, 'addSubscriptionAjax'])->name('add.subscription.ajax');
Route::post('/subscription/delete', [SubscriptionController::class, 'deleteSubscription'])->name('subscription.delete');
Route::post('/subscription/update-status', [SubscriptionController::class, 'updateSubscriptionStatus'])->name('subscription.update.status');



/ Payment Management Routes
Route::get('/payment-management', [PaymentController::class, 'payment'])->name('payment');
Route::get('/payment/data', [PaymentController::class, 'getPayments'])->name('payment.data');
Route::post('/payment/add', [PaymentController::class, 'addPaymentAjax'])->name('add.payment.ajax');
Route::post('/payment/delete', [PaymentController::class, 'deletePayment'])->name('payment.delete');
Route::get('/payment/details', [PaymentController::class, 'getPaymentDetails'])->name('payment.details');
Route::post('/payment/renew', [PaymentController::class, 'renewPayment'])->name('payment.renew');
Route::post('/payment/cancel', [PaymentController::class, 'cancelPayment'])->name('payment.cancel');
Route::post('/payment/approve', [PaymentController::class, 'approvePayment'])->name('payment.approve');
Route::get('/payment/export', [PaymentController::class, 'exportPayments'])->name('payment.export');

// Cache clear route
/* Route::get('/clear-cache', function() {
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');
    return "✅ All caches cleared successfully!";
}); */
