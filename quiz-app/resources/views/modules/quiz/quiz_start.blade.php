@extends('layouts.user')

@section('title', 'Quiz Start')
@section('page-title', 'Quiz Start')
@section('breadcrumb', 'Quiz Start') 

@section('content')

<style>
	.question_number.active.pending_answered.attempted_question {
		background-color: #e91e77;
		color: white;
		border: 2px solid darkgreen;
	}
	.question_number.pending_answered.attempted_question {
		background-color: #e91e77;
		color: white;
	}

	.question_number.unanswered {
		background-color: gray;
		color: white;
	}

	.question_number.unanswered.active {
		background-color: gray;
		color: white;
		border: 2px solid darkgreen;
	}


	.successfully_submit_certificate-card {
		background: #fff;
		border-radius: 12px;
		text-align: center;
		box-shadow: 0 10px 30px rgba(0,0,0,0.08);
	}

	.successfully_submit_certificate-icon {
		font-size: 60px;
		color: #cfa23f;
		margin-bottom: 20px;
	}

	.successfully_submit_ribbon {
		display: inline-block;
		background: linear-gradient(135deg, #d4af37, #b08d2d);
		color: #fff;
		padding: 14px 40px;
		font-size: 22px;
		font-weight: 600;
		border-radius: 30px;
		margin-bottom: 20px;
	}

	.successfully_submit_certificate-text {
		font-size: 18px;
		color: #555;
		margin-bottom: 20px;
	}

	.successfully_submit_download-link a {
		color: #0d6efd;
		font-weight: 600;
		text-decoration: none;
	}

	.successfully_submit_download-link a:hover {
		text-decoration: underline;
	}

	.successfully_submit_note {
		font-size: 13px;
		color: #777;
		margin-top: 25px;
	}
</style>

<input type="hidden" name="userAnswersWithIdQuizId" class="userAnswersWithIdQuizId">
<input type="hidden" name="time_out_message" class="time_out_message">

<section class="quiz_container quiz-card" id="quiz_container">
	<div class="container">
		<div class="quiz-header text-center">
		
			<h3>From Data to Decisions: <span class="quiz_heading_title"></span></h3>
			<p class="text-success"> 
				Start Date : <span class="quiz_heading_start_date"></span> &nbsp; | &nbsp; 
				End Date : <span class="quiz_heading_end_date"></span> 
			</p>
			<div class="d-flex justify-content-end mt-2">
				<a href="{{route('term.condition')}}" class="btn btn-outline-danger me-2">Terms and Conditions</a>
				
				@if(Auth::check())
					<button class="btn btn-outline-primary login_to_start_quiz">Start Quiz</button>
				@else
					<button class="btn btn-outline-primary login_to_start_quiz">Login to Start Quiz</button>
				@endif
			</div>
		</div>
		<div class="quiz-card card mt-4 p-3">
			<div class="quiz_submit_container"></div>
			<div class="quiz_card_container"></div>
			<div class="quiz_attempt_message text-center h5" style="color:#e91e77; margin-bottom:10px;"></div>
		</div>
		
		<div class="about-quiz">
			<h5>About Quiz</h5>
			<p class="quiz_description"></p>
		</div>
	</div>
</section>

<script>
		
		$(document).ready(function(){
			
			function handleMenuView() {
				if ($(window).width() <= 768) {
					$('.desktop-nav').hide();
					$('.mobile-nav-btn').show();
				} else {
					$('.desktop-nav').show();
					$('.mobile-nav-btn').hide();
					$('.mobile-nav').removeClass('active').hide();
				}
			}
			handleMenuView();
			$(window).on('resize', function () {
				handleMenuView();
			});

			$('#mobileNavBtn').on('click', function () {
				$('#mobileNav').addClass('active').fadeIn(200);
			});

			$('#mobileNavClose, .mobile-nav-link').on('click', function () {
				$('#mobileNav').removeClass('active').fadeOut(200);
			});
			
			let userAnswers = [];
			let userAnswersWithIdQuizId = [];
			
			$('.quiz_submit_container').hide();

			/* $('.question_class').on('copy cut contextmenu selectstart', function (e) {
				e.preventDefault();
				return false;
			}); */
			//for future use
			/* $(document).on('copy cut contextmenu selectstart', function (e) {
				e.preventDefault();
				return false;
			}); */
			
			$(document).on('click' , '.question_number' , function(){
				var questionid = $(this).data('questionnumberid');
				var quizid = $(this).data('quizid');
				$('.question_number').removeClass('active');
				$(this).addClass('active');
				
				renderQuestion(questionid-1);


				let currentIndex = $('.question_number.active').index();
				if (!userAnswers[currentIndex]) {
					userAnswers[currentIndex] = null; 
				}
				updateSkipAttempt();
				updateQuestionNumbers();
			});
			
			$(document).on('click' , '.go_to_quiz' , function(){
				window.location='../';
			});
			
			$(document).on('click', '.login_to_start_quiz', function(){
				$('.start_quiz_button').click();
			});

			$(document).on('click', '.finish_question', function(){
				$('.time_out_message').val('finish question');
				finishQuestion();
			});

			function finishQuestion() {
				
				showLoader();
				let storedValue = $('.userAnswersWithIdQuizId').val();

				/* if (!storedValue) {
					hideLoader();
					showToaster('error' , 'No answers found!');
					return;
				} */

				let parsedValue;
				try {
					parsedValue = JSON.parse(storedValue);
				} catch (e) {
					hideLoader();
					parsedValue = {};
					//showToaster('error' , 'Invalid answer data!');
				}

				$.ajax({
					url: "{{ route('submit.quiz.by.user') }}",
					type: "POST",
					data: {
						id: "{{ $id }}",
						parsedValue: parsedValue,
						message: $('.time_out_message').val(),
						_token: "{{ csrf_token() }}"
					},
					success: function (response) {
						hideLoader();
						$('.time_out_message').val('');

						if (response.status === 'success') {
							//var message = response.message + "\nYour Score: " + response.score;
							showToaster('success' , response.message);
							successMessage();
						} else {
							showToaster('error' , response.message);
						}
					},
					error: function (xhr) {
						$('.time_out_message').val('');
						hideLoader();
						let response = xhr.responseJSON;

						if (response && response.message) {
							showToaster('error' , response.message);
						} else {
							showToaster('error' , 'Server error. Please try again');
						}
					}
				});
			}
			

			let QUIZ_QUESTIONS = [];
			quizData();

			function quizData() {
				showLoader();
				
				$('.quiz_heading_title').text('');
				$('.quiz_heading_start_date').text('');
				$('.quiz_heading_end_date').text('');
				$('.quiz_card_container').html('');
				$('.quiz_description').html('');
				$('.quiz_attempt_message').html('');

				$.ajax({
					url: "{{ route('quiz.data.for.user') }}",
					type: "POST",
					data: { 
						id: '{{$id}}',
						_token: "{{ csrf_token() }}"
					},
					success: function(response) {
						hideLoader();	
	
						$('.quiz_heading_title').text(response.data.quiz_title);
						$('.quiz_heading_start_date').text(getFormatDate(response.data.start_date));
						$('.quiz_heading_end_date').text(getFormatDate(response.data.end_date));
						$('.quiz_description').html(response.data.quiz_description);
						
						if (response.status) {
							QUIZ_QUESTIONS = response.questions;
							
							let totalQuestions = response.questions.length;
							let html = '';
							
							if (!response.data || Object.keys(response.data).length === 0) {
								html = `<p style="text-align:center;color:#999;">No quiz found</p>`;
							} else {
								let quiz = response.data; 
								let diffFormatted = quiz.timer;
								$('.quiz_expire').text(formatTimeDiff(quiz.start_date, quiz.end_date));
								
								@if(Auth::check())
									//showToaster('success' , 'User logged in → redirect to quiz page!');
									var start_button = `<button 
										data-total_questions="${totalQuestions}" 
										data-quizid="${quiz.id}" 
										data-timer="${quiz.timer}" 
										data-status="user_logged_in_true" 
										class="start_quiz_button btn btn-primary w-100 mb-3">
										Start QUIZ
									</button>`;

								@else
									//showToaster('error' , 'Please login first to start the quiz!');
									var start_button = '<button data-status="user_logged_in_false" class="start_quiz_button btn btn-primary w-100 mb-3">LOGIN TO PLAY QUIZ</button>';
								@endif
								 
								var img_url = "{{ asset('assets/images/quiz_images/quiz_default_image.webp') }}";
								
								if(quiz.quiz_image){
									var img_url = "{{ asset('assets/images/quiz_images') }}"+"/"+quiz.quiz_image;
								}
								
								html += `
								<div class="row g-0 align-items-center">
									<div class="col-md-6">
										<img src="${img_url}" alt="Quiz" class="img-fluid rounded-start" style="object-fit: cover; width: 100%; height: 286px; border-radius: 12px;">
									</div>
									<div class="col-md-6 p-4">
										<h4 class="mb-3">Quiz Details</h4>
										<p><strong>Difficulty Level:</strong> ${quiz.difficulty}</p>
										<div class="quiz-stats d-flex justify-content-between mb-3">
											<div class="quiz-stat text-center">
												<h4>${totalQuestions}</h4>
												<p>QUESTIONS</p>
											</div>
											<div class="quiz-stat text-center">
												<h4>${diffFormatted}</h4>
											</div>
										</div>
										${start_button}
									</div>
								</div>`;
							}

							$('.quiz_card_container').html(html);
							$('.start_quiz_button').prop('disabled', true);
							
							if(totalQuestions != 0){
								$('.start_quiz_button').prop('disabled', false);
							}

							if (response.attemoted) {
								$('.start_quiz_button').prop('disabled', true).text('Already Attempt');
								if(response.quiz_attempt_status == 'pending'){
									$('.quiz_attempt_message').html('You have already attempted the quiz or refreshed the page, hence you cannot attempt the quiz with this ID.');
								}
							}			

						}

					},
					error: function(xhr) {
						hideLoader();
						console.log(xhr.responseText);
					}
				});
			}
			
			var index = 1;
			function renderQuestion(index) {
				let q = QUIZ_QUESTIONS[index];
				if (!q) return;

				let selectedOption = userAnswers[index] || null;

				$('.dyanamic_rander_question').html(`
					<div class="d-flex justify-content-between mb-3">
						<div class="question_class"><strong>Q${index + 1}.</strong> ${q.question_text}</div>
					</div>
					<div class="form-check mb-2">
						<input class="form-check-input" data-id="${q.id}" data-quiz_id="${q.quiz_id}" type="radio" name="answer" value="1" ${selectedOption == 1 ? 'checked' : ''}>
						<label class="form-check-label">${q.option_1}</label>
					</div>
					<div class="form-check mb-2">
						<input class="form-check-input" data-id="${q.id}" data-quiz_id="${q.quiz_id}" type="radio" name="answer" value="2" ${selectedOption == 2 ? 'checked' : ''}>
						<label class="form-check-label">${q.option_2}</label>
					</div>
					<div class="form-check mb-2">
						<input class="form-check-input" data-id="${q.id}" data-quiz_id="${q.quiz_id}" type="radio" name="answer" value="3" ${selectedOption == 3 ? 'checked' : ''}>
						<label class="form-check-label">${q.option_3}</label>
					</div>
					<div class="form-check mb-4">
						<input class="form-check-input" data-id="${q.id}" data-quiz_id="${q.quiz_id}" type="radio" name="answer" value="4" ${selectedOption == 4 ? 'checked' : ''}>
						<label class="form-check-label">${q.option_4}</label>
					</div>
					<div class="d-flex justify-content-between question_actions"></div>
				`);

				$('.form-check-input').off('click').on('click', function() {
					let id = parseInt($(this).data('id'));
					let quiz_id = parseInt($(this).data('quiz_id'));
					let selectedVal = parseInt($(this).val());

					userAnswers[index] = selectedVal;

					let existingIndex = userAnswersWithIdQuizId.findIndex(item => item.id === id && item.quiz_id === quiz_id);

					if (existingIndex > -1) {
						userAnswersWithIdQuizId[existingIndex].selected = selectedVal;
					} else {
						userAnswersWithIdQuizId.push({
							question_id: id,
							quiz_id: quiz_id,
							selected_option: selectedVal
						});
					}
					updateSkipAttempt();
					updateQuestionNumbers();
					
					$('.userAnswersWithIdQuizId').val(JSON.stringify(userAnswersWithIdQuizId));
				});
			}

			$(document).on('click', '.start_quiz_button', function () {
				
				$('.time_out_message').val('quiz started');
				
				if ($(this).data('status') !== 'user_logged_in_true') {
					showToaster('error', 'Please login first to start the quiz!');
					window.location = '../login';
					return;
				}

				var total_questions = $(this).data('total_questions');
				var quizid = $(this).data('quizid');
				var timer = $(this).data('timer') / 60;
				
				startAtamptQuiz(quizid);
				
				var questionNumbersHtml = '';
				
				for (let i = 1; i <= total_questions; i++) {
					// check if this is the last question
					let extraClass = '';
					if (i === total_questions) {
						extraClass = 'last_question';
					}

					questionNumbersHtml += `
						<div data-quizid="${quizid}" data-questionnumberid="${i}" 
							 class="question_number ${i === 1 ? 'active' : ''} ${extraClass}">
							${i}
						</div>`;
				}


				var html = `
				<div class="quiz_question_header mb-3" style="color:#e91e77;"><i class="fa-solid fa-magnifying-glass"></i> Build and Protect Your Wealth – Quiz </div>

				<div class="row">
					<div class="col-md-3">
						<div class="skip_atampt">Answered | Not Atampt </div>
						<div class="card mb-3 question_container_for_hide">
							<div class="card-body">
								<p><strong>Total Questions : ${total_questions}</strong></p>
								<div class="question_numbers">${questionNumbersHtml}</div>
							</div>
						</div>
					</div> 
					<div class="col-md-9">
						<div class="question_timer"><i class="fa-solid fa-clock"></i> 00:00:00</div>
						<div class="question_box card">
							<div class="timer_progress_container"><div class="timer_progress_bar"></div></div>
							<div class="question_container_for_show"></div>
							
							<div class="question_container_for_hide dyanamic_rander_question">
								
							</div>
						</div>
					</div>
				</div>`;

				$('.quiz_card_container').html(html);
				
				
				startTimer(Math.round(timer * 60));

				function updateButtons() {
					let total = $('.question_number').length;
					let activeIndex = $('.question_number.active').index() + 1;
					let btnHtml = '';

					if (activeIndex === 1) {
						btnHtml = `
							<button class="btn btn-secondary next_question">Skip</button>
							<div class="d-flex gap-2"><button class="btn btn-primary next_question">Next</button></div>`;
					} 
					else if (activeIndex === total) {
						btnHtml = `
							<div></div>
							<div class="d-flex gap-2">
								<button class="btn btn-secondary prev_question">Prev</button>
								<button class="btn btn-primary finish_question">Finish</button>
							</div>
						`;
					} 
					else {
						btnHtml = `
							<button class="btn btn-secondary next_question">Skip</button>
							<div class="d-flex gap-2">
								<button class="btn btn-secondary prev_question">Prev</button>
								<button class="btn btn-primary next_question">Next</button>
							</div>
						`;
					} 

					$('.question_actions').html(btnHtml);
				}

				updateButtons();

				$(document).on('click', '.question_number', function () {
					$('.question_number').removeClass('active');
					$(this).addClass('active');
					updateButtons();
					updateQuestionNumbers();
				});
				
				$(document).on('click', '.next_question', function () {
					let currentIndex = $('.question_number.active').index();
					
					if ($(this).text().toLowerCase() === 'skip' || $(this).text().toLowerCase() === 'next') {
						if (!userAnswers[currentIndex]) {
							userAnswers[currentIndex] = null; 
						}
					}

					updateSkipAttempt();
					updateQuestionNumbers();
					$('.question_number.active').next('.question_number').click();
				});

				$(document).on('click', '.prev_question', function () {
					$('.question_number.active').prev('.question_number').click();
				});
				
				$('.question_number[data-questionnumberid="1"]').trigger('click');
			});
			
			function startAtamptQuiz(quiz_id){
				showLoader();
				$.ajax({
					url: "{{ route('attempt.quiz.by.user') }}",
					type: "POST",
					data: {
						quiz_id: quiz_id,
						_token: "{{ csrf_token() }}"
					},
					success: function (response) {
						hideLoader();
					},
					error: function (xhr) {
						hideLoader();
						let response = xhr.responseJSON;

						if (response && response.message) {
							console.log('error' , response.message);
						} else {
							console.log('error' , 'Server error. Please try again');
						}
					}
				});
			}
			
			function getFormatDate(date) {
				var date = new Date(date);
				var options = {
					year: 'numeric',
					month: 'short',   
					day: 'numeric',
					hour: 'numeric',
					minute: 'numeric',
					hour12: true      
				};
				var humanReadable = date.toLocaleString('en-US', options);
				return humanReadable;
			}
			
			function formatTimeDiff(start, end) {
				let startDate = new Date(start);
				let endDate = new Date(end);
				let diffSeconds = Math.floor((endDate - startDate) / 1000);
				let days = Math.floor(diffSeconds / (24 * 3600));
				diffSeconds %= (24 * 3600);
				let hours = Math.floor(diffSeconds / 3600);
				diffSeconds %= 3600;
				let minutes = Math.floor(diffSeconds / 60);
				let seconds = diffSeconds % 60;
				let result = "";
				if (days > 0) result += days + " day" + (days > 1 ? "s " : " ");
				if (hours > 0) result += hours + " hr" + (hours > 1 ? "s " : " ");
				if (minutes > 0) result += minutes + " min" + (minutes > 1 ? "s " : " ");
				if (seconds > 0 && days === 0) result += seconds + " sec";

				return result.trim();
			}
			
			
			function startTimer(duration) {
				var totalSeconds = duration;
				var initialDuration = duration;

				function formatTime(seconds) {
					var hrs = Math.floor(seconds / 3600);
					var mins = Math.floor((seconds % 3600) / 60);
					var secs = seconds % 60;

					return (
						(hrs < 10 ? "0" + hrs : hrs) + ":" +
						(mins < 10 ? "0" + mins : mins) + ":" +
						(secs < 10 ? "0" + secs : secs)
					);
				}  

				$('.question_timer').text("⏰ " + formatTime(totalSeconds));
				$('.timer_progress_bar').css('width', '0%').css('background', 'green');

				var timer = setInterval(function() {
					totalSeconds--;

					$('.question_timer').text("⏰ " + formatTime(totalSeconds));
					var progressPercent = ((initialDuration - totalSeconds) / initialDuration) * 100;
					$('.timer_progress_bar').css('width', progressPercent + '%');

					if (progressPercent < 50) {
						$('.timer_progress_bar').css('background', 'green');
					} else if (progressPercent < 80) {
						$('.timer_progress_bar').css('background', 'orange');
					} else {
						$('.timer_progress_bar').css('background', 'red');
					}

					if (totalSeconds <= 0) {
						clearInterval(timer);
						
						$('.timer_progress_bar').css('width', '100%').css('background', 'red');
						$('.question_container_for_hide').hide();
						
						var timeOverHtml = `
							<div class="container mt-4">
								<div class="row justify-content-center">
									<div class="col-md-8">
										<div class="alert alert-danger text-center p-4 rounded shadow">
											<h4 class="alert-heading mb-3">⏰ Time Has Elapsed!</h4>
											<p class="mb-2">Your quiz time has <strong>expired</strong>.</p>
											<p class="mb-3">You can no longer attempt any questions.</p>
											<hr>
											<p class="mb-0 text-muted">Thank you for participating in the quiz!.</p>
										</div>
									</div>
								</div>
							</div>
						`;

						$('.question_container_for_show').html(timeOverHtml);
						$('.quiz_question_header').html('<a class="go_to_quiz" style="cursor:pointer;">Go To Quiz</a>');
						
						$('.time_out_message').val('time out');
						
						finishQuestion();
					}
				}, 1000);
			}
			
			function updateSkipAttempt() {
				let answeredCount = userAnswers.filter(a => a !== null).length;
				let skippedCount = QUIZ_QUESTIONS.length - answeredCount;
				$('.skip_atampt').text(`Answered: ${answeredCount} | Not Atampt: ${skippedCount}`);
			}
			
						
			function updateQuestionNumbers() {
				$('.question_number').each(function(index) {
					$(this).removeClass('pending_answered unanswered attempted_question');

					if (userAnswers[index] !== null) {
						$(this).addClass('pending_answered');
					} else {
						$(this).addClass('unanswered');
					}

					if (userAnswers[index] === 1 || userAnswers[index] === 2 || userAnswers[index] === 3 || userAnswers[index] === 4) {
						$(this).addClass('attempted_question');
					}
				});
			}
			
			function successMessage(){
				var html_for_success = `<div class="successfully_submit_certificate-card"><div class="successfully_submit_certificate-icon">🏆</div><div class="successfully_submit_ribbon">Congratulations</div><div class="successfully_submit_certificate-text">Thank you <strong>for participating in the Quiz</strong></div><div class="successfully_submit_download-link"><a href="#">Click here</a> to download the Certificate</div><div class="successfully_submit_note">ℹ️ This is a digitally generated certificate. No signature is required.</div><br></div>`; 
							
				$('.quiz_submit_container').show();
				$('.quiz_submit_container').html(html_for_success);
				$('.quiz_card_container').hide();
			}
				
            let total_questions = QUIZ_QUESTIONS.length;
			userAnswers = new Array(total_questions).fill(null); 
			updateQuestionNumbers(); 

		});
    </script>
	
@endsection