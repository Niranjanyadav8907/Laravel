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
use App\Http\Controllers\FooterController;
use App\Http\Controllers\QuizmasterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserquizReportController;


/*
|--------------------------------------------------------------------------
| Root Redirect - Auto redirect to login or dashboard
|--------------------------------------------------------------------------
*/
Route::middleware(['logs'])->group(function () {
		
	Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
	Route::get('/register', [AuthController::class, 'showRegistration'])->name('showRegistration');
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
	Route::post('/register', [AuthController::class, 'ajaxRegister'])->name('ajax.register');
	Route::post('/login', [AuthController::class, 'ajaxLogin'])->name('ajax.login');
	Route::get('/admin-dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
	Route::post('/dashboard-content', [DashboardController::class, 'dashboardContent'])->name('dashboard.content'); 


	Route::get('/user-dashboard', [DashboardController::class, 'adminDashboard'])->name('user.dashboard');

	Route::prefix('profile')->group(function () {
		Route::get('/', [UsersController::class, 'profile'])->name('profile');
		Route::get('/user', [UsersController::class, 'userProfile'])->name('user.profile');
		Route::post('/update', [UsersController::class, 'updateProfile'])->name('profile.update');
		Route::delete('/remove-image', [UsersController::class, 'removeProfileImage'])->name('profile.remove-image');
	});

	Route::middleware(['role'])->group(function () {
		Route::prefix('user')->group(function () {
			Route::get('/', [UsersController::class, 'all'])->name('users');
			Route::get('/add', [UsersController::class, 'add'])->name('add.user');
			Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('edit.user');
			Route::post('/delete', [UsersController::class, 'delete'])->name('users.delete');

			Route::prefix('ajax')->group(function () {
				Route::get('/', [UsersController::class, 'getUsers'])->name('users.data'); 
			});
			
			Route::prefix('quiz-report')->group(function () {
				Route::get('/', [UserquizReportController::class, 'index'])->name('user.quiz.report');
				Route::get('/data', [UserquizReportController::class, 'reportData'])->name('user.quiz.report.data');
				Route::get('/result/{userId}', [UserquizReportController::class, 'userResult']) ->name('user.quiz.report.result');

				Route::get('/achievements/{userId}', [UserquizReportController::class, 'userAchievements']);
				Route::get('/history/{userId}', [UserquizReportController::class, 'userQuizHistory']) ->name('user.quiz.report.history');
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
		
		Route::prefix('category')->group(function () {
			Route::get('/', [QuizController::class, 'addQuizCategory'])->name('add.quiz.category');
			Route::get('/data', [QuizController::class, 'getQuizCategory'])->name('quiz.category.data');
			Route::post('/add', [QuizController::class, 'addCategoryAjax'])->name('add.category.ajax');
			Route::post('/delete', [QuizController::class, 'deleteCategory'])->name('category.delete');		
		});

		Route::prefix('schedule')->group(function () {
		Route::get('/schedule', [QuizController::class, 'schedule'])->name('quiz.schedule');
		Route::post('/update-quiz-planner', [QuizController::class, 'updateQuizPlanner'])->name('quiz.planner.update');
		Route::post('/update-schedule-type', [QuizController::class, 'updateScheduleType'])->name('quiz.schedule.type.update');
		Route::post('/update-quiz-control', [QuizController::class, 'updateQuizControl'])->name('quiz.control.update');
		Route::get('/schedule-data', [QuizController::class, 'getScheduleData'])->name('quiz.schedule.data');
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

	Route::prefix('achievement')->group(function () {
		Route::get('/', [AchievementController::class, 'achievement'])->name('achievement');
		Route::get('/data', [AchievementController::class, 'getAchievements'])->name('achievement.data');
		Route::post('/add', [AchievementController::class, 'addAchievementAjax'])->name('add.achievement.ajax');
		Route::post('/delete', [AchievementController::class, 'deleteAchievement'])->name('achievement.delete');
		Route::post('/update-status', [AchievementController::class, 'updateAchievementStatus'])->name('achievement.update.status');
		Route::post('/achievement-sync', [AchievementController::class, 'achievementSync'])->name('achievement.sync');
	});

	// Subscription Routes
	Route::prefix('plan')->group(function () {
		Route::get('/', [SubscriptionController::class, 'subscription'])->name('subscription');
		Route::get('/data', [SubscriptionController::class, 'getSubscriptions'])->name('subscription.data');
		Route::post('/add', [SubscriptionController::class, 'addSubscriptionAjax'])->name('add.subscription.ajax');
		Route::post('/delete', [SubscriptionController::class, 'deleteSubscription'])->name('subscription.delete');
		Route::post('/update-status', [SubscriptionController::class, 'updateSubscriptionStatus'])->name('subscription.update.status');
	});

	// Payment Management Routes
	Route::prefix('payment')->group(function () {
		Route::get('/', [PaymentController::class, 'payment'])->name('payment');
		Route::get('/data', [PaymentController::class, 'getPayments'])->name('payment.data');
		Route::post('/add', [PaymentController::class, 'addPaymentAjax'])->name('add.payment.ajax');
		Route::post('/delete', [PaymentController::class, 'deletePayment'])->name('payment.delete');
		Route::get('/details', [PaymentController::class, 'getPaymentDetails'])->name('payment.details');
		Route::post('/renew', [PaymentController::class, 'renewPayment'])->name('payment.renew');
		Route::post('/cancel', [PaymentController::class, 'cancelPayment'])->name('payment.cancel');
		Route::post('/approve', [PaymentController::class, 'approvePayment'])->name('payment.approve');
		Route::get('/export', [PaymentController::class, 'exportPayments'])->name('payment.export');
		Route::get('/search-users', [PaymentController::class, 'searchUsers'])->name('payment.search.users');
	});


	Route::get('/privacy-notice', [FooterController::class, 'privacyNotice'])->name('privacy.notice');
	Route::get('/term-condition', [FooterController::class, 'termCondition'])->name('term.condition');
	Route::get('/accessibility-declaration', [FooterController::class, 'accessibilityDeclaration'])->name('accessibility.declaration');
	Route::get('/disclaimer', [FooterController::class, 'disclaimer'])->name('disclaimer');
	Route::get('/security-policy', [FooterController::class, 'securityPolicy'])->name('security.policy');


	Route::prefix('quizmaster/')->group(function () { 
		Route::get('/', [QuizmasterController::class, 'index'])->name('quizmaster.index');
		Route::get('/data', [QuizmasterController::class, 'getData'])->name('quizmaster.data');
		Route::post('/store', [QuizmasterController::class, 'store'])->name('quizmaster.store');
		Route::post('/delete', [QuizmasterController::class, 'delete'])->name('quizmaster.delete');
		Route::post('/update-status', [QuizmasterController::class, 'updateStatus'])->name('quizmaster.update.status');
	});

	Route::middleware(['auth'])->group(function () {
		Route::get('/user-dashboard', [UsersController::class, 'userDashboard']) ->name('user.dashboard');
		Route::get('/user-dashboard/data', [UsersController::class, 'userDashboardData']) ->name('user.dashboard.data');

		Route::get('/quiz-history', [UsersController::class, 'quizHistory']) ->name('quiz.history');
		Route::get('/quiz-history/data', [UsersController::class, 'quizHistoryData']) ->name('quiz.history.data');
		Route::get('/quiz-history/detail/{attemptId}', [UsersController::class, 'quizHistoryDetail'])->name('quiz.history.detail');
		Route::get('/my-result', [UsersController::class, 'myResult']) ->name('user.result');
		Route::get('/my-result/data', [UsersController::class, 'myResultData']) ->name('user.result.data');
		Route::get('/achievements', [UsersController::class, 'userAchievements']) ->name('user.achievements');

	});
    
	Route::prefix('settings')->group(function () { 	
		Route::get('/', [SettingsController::class, 'addSettings']) ->name('settings');
		Route::post('/add', [SettingsController::class, 'addSettingsAjax'])->name('add.settings.ajax');  
		Route::get('/get', [SettingsController::class, 'getSettings'])->name('settings.data'); 
		Route::post('/delete', [SettingsController::class, 'delete'])->name('quiz.settings');
	});
	
	Route::get('/activity-log', [SettingsController::class, 'activityLog']) ->name('activity.log');
	Route::get('/get-activity-log', [SettingsController::class, 'getActivityLog'])->name('activity.logs.data'); 
		
	
});




// Cache clear route
/* Route::get('/clear-cache', function() {
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');
    return "✅ All caches cleared successfully!";
}); */

