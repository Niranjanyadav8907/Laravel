@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="row mt-2 m-1">
    <div class="col-lg-3 col-6">
		<div class="small-box bg-info">
			<div class="inner">
				<h3 class="total_users">0</h3>
				<p>Total Users</p>
				<hr style="margin:8px 0;"> 
				<div class="roleCountsContainer"></div>
				<hr>
				<div class="statusCountsContainer"></div>
			</div>

			<div class="icon"><i class="fas fa-users"></i></div>
			<a class="small-box-footer refresh_data cursor-pointer">Refresh List <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
    <!-- Leaderboard -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-teal">
            <div class="inner">
                <h3 class="top_scorers_count">0</h3>
                <p>Leaderboard</p>
                <hr style="margin:8px 0;">
                <div class="topScorersContainer"></div>
            </div>
            <div class="icon"><i class="fas fa-trophy"></i></div>
            <a class="small-box-footer refresh_data cursor-pointer">Refresh List <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- Active Plans -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3 class="active_plans">0</h3>
                <p>Active Plans</p>
                <hr style="margin:8px 0;">
                <div class="activePlansContainer"></div>
            </div>
            <div class="icon"><i class="fas fa-crown"></i></div>
            <a class="small-box-footer refresh_data cursor-pointer">Refresh List <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3 class="total_roles">0</h3>
                <p>Total roles</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a class="small-box-footer refresh_data cursor-pointer">Refresh List <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3 class="total_quizs">0</h3>
                <p>Total Quiz</p>
            </div>
            <div class="icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <a class="small-box-footer refresh_data cursor-pointer">Refresh List <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- Quiz Attempts --> 
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3 class="total_attempts">0</h3>
                <p>Quiz Attempts</p>
            </div>
            <div class="icon">
                 <i class="fas fa-chart-line"></i>
            </div>
            <a class="small-box-footer refresh_data cursor-pointer">Refresh List <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        
    </div>

    <!-- Total Questions -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3 class="total_questions">0</h3>
                <p>Total Questions</p>
            </div>
            <div class="icon"><i class="fas fa-question-circle"></i></div>
            <a class="small-box-footer refresh_data cursor-pointer">Refresh List <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-12 row">
    <div class="col-6">
        <div class="small-box bg-white">
            <div class="inner">
                <h6 class="text-dark text-capitalize ps-3 mb-3">Top Scorers</h6>
                <div class="table-responsive">
                    <table class="table leaderboardTable align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Rank</th>
                                <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">User</th>
                                <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Score / Attempt</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <a class="small-box-footer refresh_leaderboard cursor-pointer">Refresh List <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-6">
        <div class="small-box bg-white">
            <div class="inner">
                <h6 class="text-dark text-capitalize ps-3 mb-3">Achievement Management</h6>
                <div class="table-responsive">
                    <table class="table achievementTable align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Achievement</th>
                                <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Criteria Type</th>
                                <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Value</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <a class="small-box-footer refresh_leaderboard cursor-pointer">Refresh List <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    
    </div>
    </div>

</div>

<script>

$(document).ready(function() {
	
	$(document).on('click' , '.refresh_data' , function(){
		dashBoardCOntent();
	})
	
	
	dashBoardCOntent();

	function dashBoardCOntent(){
		
		showLoader();
		$.ajax({
			url: "{{ route('dashboard.content') }}",
			type: "POST",
			data: {
				_token: "{{ csrf_token() }}",
				id: 10,
				date: '2026-01-20'
			},
			beforeSend: function () {
				//console.log('Please wait...');
			},
			success: function (response) {
				hideLoader();
				if (response.status) {

					let roleHtml = '';
					$('.total_roles').text(0);
					$('.total_quizs').text(0);
					$('.total_attempts').text(0);
					$('.total_questions').text(0);
					
					if (response.role_counts && response.role_counts.length > 0) {
						response.role_counts.forEach(function (item) {
							
							roleHtml += `
								<p class="mb-1">
									<strong>${item.role_slug}:</strong>
									<span>${item.total}</span>
								</p>
							`;
						});
					} else {
						roleHtml = `<p class="mb-1 text-muted">No role data</p>`;
					}

					$('.roleCountsContainer').html(roleHtml);
					
					if(response.total_roles){
						$('.total_roles').text(response.total_roles);
					}
					
					if(response.total_quizs){
						$('.total_quizs').text(response.total_quizs);
					}

					
					if (response.total_quiz_attempts !== undefined) {
						$('.total_attempts').text(response.total_quiz_attempts);
					}

					if (response.total_questions !== undefined) {
						$('.total_questions').text(response.total_questions);
					}

					 

					let statusHtml = '';
					let total_user = 0;

					if (response.status_counts && response.status_counts.length > 0) {
						response.status_counts.forEach(function (item) {

							let count = parseInt(item.total) || 0; 
							total_user += count;

							statusHtml += `
								<p class="mb-1">
									<strong>${item.status}:</strong>
									<span>${count}</span>
								</p>
							`;
						});
					} else {
						statusHtml = `<p class="mb-1 text-muted">No status data</p>`;
					}

					$('.statusCountsContainer').html(statusHtml);
					$('.total_users').text(total_user);
					
					/* ---------- TOP SCORERS (ADDED) ---------- */
					$('.top_scorers_count').text(0);
					$('.topScorersContainer').html('');

					if (response.top_scorers && response.top_scorers.length > 0) {

						$('.top_scorers_count').text(response.top_scorers_count);

						let scorerHtml = '';
						response.top_scorers.forEach(function(item, index) {
							scorerHtml += `
								<p class="mb-1">
									<strong>${index + 1} ${item.name}</strong>
									<span class="float-right">${item.highest_score}</span>
								</p>
							`;
						});

						$('.topScorersContainer').html(scorerHtml);

					} else {
						$('.topScorersContainer').html(
							`<p class="text-muted mb-1">No scorer data</p>`
						);
					}

				   /* ---------- ACTIVE PLANS ---------- */
					$('.active_plans').text(0);
					$('.activePlansContainer').html('');

					if (response.active_plans && response.active_plans.length > 0) {

						$('.active_plans').text(response.active_plans_count);

						let planHtml = '';

						response.active_plans.forEach(function(item) {

							let priceText = (parseFloat(item.price) > 0)
								? `₹${item.price}`
								: 'Free';

							planHtml += `
								<div class="plan-item-inline">
									<span class="plan-name">${item.plan_name}</span>
									<span class="plan-separator"> | </span>
									<span class="plan-price">${priceText} / ${item.duration}</span>
								</div>
							`;
						});

						$('.activePlansContainer').html(planHtml);
					}

				}
			},
			error: function (xhr) {
				hideLoader();
				if (xhr.status === 422) {
					let errors = xhr.responseJSON.errors;
				}
			},
			complete: function () {
				hideLoader();
				//console.log('done...');
			}
		});
	}

	// Leaderboard AJAX Code
	getLeaderboardData();
   
	$('.refresh_leaderboard').on('click', function () {
		getLeaderboardData();
	});

	function getLeaderboardData() {
		showLoader();

		$.ajax({
			url: "{{ route('leaderboard.data') }}",
			type: "GET",
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function (response) {
				hideLoader();

				let tbody = $('.leaderboardTable tbody');
				tbody.html('');

				if (!response.status || response.data.length === 0) {
					tbody.html(`
						<tr>
							<td colspan="4" class="text-center text-muted">
								No leaderboard data found
							</td>
						</tr>
					`);
					return;
				}

				let rows = '';

				$.each(response.data, function (index, item) {
					const rank = item.rank ?? (index + 1);
					const userName = item.user?.name ?? '-';
					const score = item.highest_score ?? 0;
					const attempts = item.total_attempts ?? 0;

					rows += `
						<tr>
							<td><div class="achievement-icon rank-${rank}">${getRankIcon(rank)}</div></td>
							<td class="text-capitalize font-weight-bold text-dark">${userName}</td>
							<td>
								<div>
									<h6 class="mb-0 text-sm">Score: ${item.total_score}</h6>
									<p class="text-xs text-secondary mb-0">Attempts: ${attempts}</p>
								</div>
							</td>
						</tr>
					`;
				});

				tbody.html(rows);
			},
			error: function (xhr) {
				hideLoader();
				console.error('Failed to load leaderboard:', xhr);
			}
		});
	}

	function getRankIcon(rank) {
		switch (rank) {
			case 1:  return '👑';  // Champion
			case 2:  return '🥈';  // Silver
			case 3:  return '🥉';  // Bronze
			case 4:  return '🏅';  // Medal
			case 5:  return '🎖️'; // Honor
			case 6:  return '⭐';  // Star
			case 7:  return '🌟'; // Bright star
			case 8:  return '✨';  // Spark
			case 9:  return '🔥';  // Hot streak
			case 10: return '💎';  // Top 10 finisher
			default: return rank;  // 11+
		}
	}

	// Achievement AJAX Code
	achievementData();

	$('.refresh_achievement').on('click', function () {
		achievementData();
	});

	function achievementData() {
		showLoader();
		$.get("{{ route('achievement.data') }}").done(function(response) {
			let rows = '';
			response.forEach(achievement => {
				const description = achievement.description 
					? achievement.description.substring(0, 50) + '...' 
					: '-';
				rows += `
					<tr>
						<td>
							<div class="d-flex align-items-center">
								<div class="achievement-icon me-3" 
									 style="background: ${achievement.icon_bg_color};">
									${achievement.icon}
								</div>
								<div>
									<h6 class="mb-0 text-sm">
										${achievement.title}
									</h6>
									<p class="text-xs text-secondary mb-0">
										${description}
									</p>
								</div>
							</div>
						</td>
						<td>
							<p class="text-sm">
								${formatCriteriaType(achievement.criteria_type)}
							</p>
						</td>
						<td>
							<p class="text-sm font-weight-bold">
								${achievement.criteria_value}
							</p>
						</td>
					</tr>
				`;
			});
			$('.achievementTable tbody').html(rows);
			hideLoader();
		}).fail(function(err) {
			hideLoader();
			console.error('Achievement fetch error', err);
		});
	}

	function formatCriteriaType(type) {
		return type.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
	}

});

</script>
@endsection