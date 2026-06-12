@extends('layouts.admin')

@section('title', 'Top Scorers')
@section('page-title', 'Top Scorers')
@section('breadcrumb', 'Top Scorers')

@section('content')
<style>
.achievement-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #fff3cd;  
    border: 2px solid #ffc107; 
    font-size: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
}

</style>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Top Scorers</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2 m-4">
                    <div class="table-responsive">
                        <i class="fas fa-sync refresh_leaderboard cursor-pointer me-2" style="font-size:1.3rem;"></i>
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
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
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



});
</script>

@endsection