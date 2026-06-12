@extends('layouts.user')

@section('title', 'Winner Announcement')
@section('page-title', 'Winner Announcement')
@section('breadcrumb', 'Winner Announcement') 

@section('content')

<style>
body{
    margin:0;
    min-height:100vh;
    background: #f5f5f5;
    font-family: "Poppins", sans-serif;
}

.section-wrap{
    padding:20px 0;
}

.title{
    text-align:center;
    color:#fff;
    font-weight:700;
    letter-spacing:1px;
    margin-bottom:60px;
}

.card-box{
    background:#fff;
    border-radius:18px;
    padding:18px;
    text-align:center;
    box-shadow:0 12px 25px rgba(0,0,0,.15);
    transition:.3s;
}

.card-box:hover{
    transform:translateY(-6px);
}

.card-img{
    width:100%;
    height:230px;
    object-fit:cover;
    border-radius:12px;
}

.card-title{
    font-size:15px;
    font-weight:600;
    margin:15px 0 8px;
}

.result-link{
    color:#1e88e5;
    font-size:14px;
    font-weight:600;
    text-decoration:none;
}

.medal{
    width:55px;
    margin-top:12px;
}

.all-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:#ff4d6d;
    color:#fff;
    padding:12px 28px;
    border-radius:40px;
    font-weight:600;
    text-decoration:none;
    box-shadow:0 6px 18px rgba(0,0,0,.25);
}

.all-btn:hover{
    background:#ff2f55;
    color:#fff;
}


.winner-banner {
	background: linear-gradient(135deg,#6a1b9a,#d81b60,#ec407a);
	color: #fff;
	padding: 10px 10px;
	border-radius: 15px;
	text-align: center;
}
.winner-img {
	width: 120px;
	height: 120px;
	border-radius: 50%;
	border: 5px solid #fff;
	object-fit: cover;
}
.card {
	border-radius: 15px;
}
.badge-custom {
	font-size: 14px;
	padding: 8px 12px;
}
.leaderboard-table th {
	background-color: #343a40;
	color: white;
}
</style>

<div class="section-wrap container_winner_section_wrap">
	<div class="container">
		
		<div class="winner-banner mb-4 shadow">
			<img src="https://content.presentermedia.com/content/clipart/00033000/33316/gold_trophy_800_wht.webp" class="winner-img mb-3" alt="Winner">
			<h5 class="text-warning winner-rank"></h5>
			<h2>🎉 Congratulations!</h2>
			<h4 class="winner-position text-capitalize"></h4>
			<h4 class="text-warning mt-3 winner-score"></h4>
			<span class="text-warning mt-3">
				<div style="display:flex; gap:6px; margin-bottom:10px;">
					<a class="small-box-footer refresh_winner_data" style="cursor:pointer;">Refresh Winner List <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</span>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="card shadow mb-4">
					<div class="card-header bg-primary text-white winner-banner">Performance Details</div>
					<div class="card-body">
						<p>✅ Correct Answers: <strong class="correct_answers">0</strong></p>
						<p>⏱️ Time Taken: <strong class="time_taken">02:15 Minutes</strong></p>
						<p>🎯 Accuracy: <strong class="winner_accuracy">0%</strong></p>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card shadow mb-4">
					<div class="card-header bg-success text-white winner-banner">Prize Details</div>
					<div class="card-body">
						<p>🎁 Prize Amount: <strong>₹5,000</strong></p>
						<p>💳 Payment Status: <span class="badge bg-success badge-custom">Paid</span></p>
						<p>🧾 Transaction ID: <strong>TXN123456789</strong></p>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card shadow mb-4 winner-banner">
			<div class="text-white top_leaderboard_count">Top Leaderboard</div>
			<div class="card-body table-responsive">
				<table class="table table-bordered leaderboard-table text-center">
					<thead>
						<tr>
							<th>Rank</th>
							<th>Name/Score</th>
							<th>Accuracy</th>
						</tr>
					</thead>
					<tbody class="leaderboard-body">
					</tbody>
				</table>
			</div>
		</div>
		
		<!--
		<div class="card shadow mb-4 winner-banner">
			<div class="card-body text-center">
				<img src="https://via.placeholder.com/120" class="winner-img mb-3" alt="Winner">
				<h3>Anil Kumar</h3>
				<h5 class="text-warning">🥇 Rank #1</h5>
				<h4 class="text-success mt-3">Score: 95 Points</h4>
			</div>
		</div>
		
		<div class="card shadow mb-4">
			<div class="card-header bg-warning">
				Achievements & Badges
			</div>
			<div class="card-body text-center">
				<span class="badge bg-primary badge-custom">🏆 Quiz Master</span>
				<span class="badge bg-danger badge-custom">🔥 Winning Streak</span>
				<span class="badge bg-success badge-custom">🎯 100% Accuracy</span>
				<span class="badge bg-info badge-custom">⚡ Fastest Finger</span>
			</div>
		</div>
		
		<div class="card shadow mb-4">
			<div class="card-body text-center">
				<h5>Total Participants: 250</h5>
				<p>Average Score: 65 Points</p>
			</div>
		</div>
		<div class="text-center">
			<button class="btn btn-success me-2">Share on WhatsApp</button>
			<button class="btn btn-primary">Share on Facebook</button>
		</div> -->
	</div>
</div>


<div class="winner-banner section-wrap container_section_wrap">
	<h2 class="title">WINNER ANNOUNCEMENT</h2>
	<div class="row g-4 justify-content-center winner_anouncement_container">
		<!--<div class="col-lg-4 col-md-6">
			<div class="card-box">
				<img src="https://static.mygov.in/media/quiz/2025/11/mygov_692b28e940b9c.jpg" class="card-img">
				<div class="card-title">
					Quiz on Atmanirbhar Bharat – Mission to achieve self-reliance
				</div>
				<a href="#" class="result-link">View Results</a><br>
				<img src="https://quiz.mygov.in/wp-content/themes/quizz/assets/images/winner-ribbon.png" class="medal">
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="card-box">
				<img src="https://static.mygov.in/media/quiz/2025/11/mygov_692b26418b771.jpg" class="card-img">
				<div class="card-title">
					Quiz on India Achievements in Sports
				</div>
				<a href="#" class="result-link">View Results</a><br>
				<img src="https://quiz.mygov.in/wp-content/themes/quizz/assets/images/winner-ribbon.png" class="medal">
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="card-box">
				<img src="https://static.mygov.in/media/quiz/2025/11/mygov_692b2b89e908d.jpg" class="card-img">
				<div class="card-title">
					Quiz on India Space Achievements
				</div>
				<a href="#" class="result-link">View Results</a><br>
				<img src="https://quiz.mygov.in/wp-content/themes/quizz/assets/images/winner-ribbon.png" class="medal">
			</div>
		</div> -->
	</div>

	<div class="text-center mt-5">
		<a href="#all-winner" class="all-btn see_all_winner">See winners →</a>
	</div>

</div>


<script>
$(document).ready(function () {
	$('.container_winner_section_wrap').hide();
	$('.container_section_wrap').show();

	$(document).on('click' , '.see_all_winner' , function(){
		$('.container_winner_section_wrap').show();
		$('.container_section_wrap').hide();
	});
	
	$(document).on('click' , '.refresh_winner_data' , function(){
		getLeaderboardData();
	});
	
	function checkHash() {
        var fullUrl = window.location.href;
        var hash = window.location.hash;

        if (hash === "#all-winner") {
            $('.container_winner_section_wrap').show();
            $('.container_section_wrap').hide();

            //alert("Hash detected! Full URL is: " + fullUrl);
        } else {
            $('.container_winner_section_wrap').hide();
            $('.container_section_wrap').show();
        }
    }

    checkHash();

    $(window).on('hashchange', function () {
        checkHash();
    });
	
	getLeaderboardData();
	
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
				
				if (response.status && response.data.length > 0) {
					let leaderboard = response.data;
					let winner = leaderboard[0];

					$(".winner-position").text(
						winner.user.name + " secured " + winner.rank + getOrdinal(winner.rank) + " Position"
					);

					$(".winner-name").text(winner.user.name);
					$(".winner-rank").text("🥇 Rank #" + winner.rank);
					$(".winner-score").text("Score: " + winner.total_score + " Points");
					$(".correct_answers").text(winner.highest_score);
					
					let winner_accuracy = 0;
					if (winner.sum_total_questions && winner.sum_score) {
						if (winner.sum_total_questions > 0) {
							var percentage = (winner.sum_score / winner.sum_total_questions) * 100;
							winner_accuracy = percentage.toFixed(2) + "%";
						}
					}
					
					const start = new Date(winner.started_at);
					const end = new Date(winner.finished_at);
					const diffMs = end - start; // milliseconds difference
					const minutes = Math.floor(diffMs / 60000);
					const seconds = Math.floor((diffMs % 60000) / 1000);
					const time_taken = `${minutes} min ${seconds} sec`;
					
					$(".winner_accuracy").text(winner_accuracy);
					$(".time_taken").text(time_taken);
					
					let tableHTML = "";
					let winnerHTML = "";
					let shownCount = 0;

					leaderboard.forEach(function (item) {
						if (item.rank > 3) return;
						shownCount++;
						
						let accuracy = 0;
						if (item.sum_total_questions && item.sum_score) {
							if (item.sum_total_questions > 0) {
								var percentage = (item.sum_score / item.sum_total_questions) * 100;
								accuracy = percentage.toFixed(2) + "%";
							}
						}

						tableHTML += `
							<tr>
								<td>${item.rank}</td>
								<td>
									<div>
										<h6 class="mb-0 text-sm text-capitalize">${item.user.name}</h6>
										<p class="text-xs text-secondary mb-0">Score: ${item.total_score}</p>
									</div>
								</td>
								<td>
									<div>
										<h6 class="mb-0 text-sm text-capitalize">${accuracy}</h6>
										<p class="text-xs text-secondary mb-0">Attempt: ${item.total_attempts}</p>
									</div>
								</td>
							</tr>
						`;
						
						var img_url = "{{ asset('assets/images/quiz_images/quiz_default_image.webp') }}";
						if(item.quiz.quiz_image){
							img_url = "{{ asset('assets/images/quiz_images') }}/" + item.quiz.quiz_image;
						}
						
						winnerHTML += `
							<div class="col-lg-4 col-md-6">
								<div class="card-box">
									<img src="${img_url}" class="card-img">
									<div class="card-title text-dark">${item.quiz.quiz_title}</div>
									<a href="#all-winner" class="result-link see_all_winner">View Results</a><br>
									<img src="https://quiz.mygov.in/wp-content/themes/quizz/assets/images/winner-ribbon.png" class="medal">
								</div>
							</div>
						`;
					});

					$(".leaderboard-body").html(tableHTML);
					$(".winner_anouncement_container").html(winnerHTML);
					$('.top_leaderboard_count').html("Top " + shownCount + " Leaderboard:");
				}
			},
			error: function (xhr) {
				hideLoader();
				console.error('Failed to load leaderboard:', xhr);
			}
		});
	}
	
	
	function getOrdinal(n) {
		if (n == 1) return "st";
		if (n == 2) return "nd";
		if (n == 3) return "rd";
		return "th";
	}

});
</script>
@endsection