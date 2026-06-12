@extends('layouts.user')

@section('title', 'QUIZ InQuizitive - Test Your Knowledge')
@section('page-title', 'QUIZ InQuizitive - Test Your Knowledge')
@section('breadcrumb', 'QUIZ InQuizitive - Test Your Knowledge')
@section('content')
<style>
	.quote-section {
		/*background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);*/
		padding: 20px 0;
		color: #fff;
	}

	.quote-card {
		background: rgba(255, 255, 255, 0.1);
		backdrop-filter: blur(10px);
		border-radius: 20px;
		padding: 40px;
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
		transition: 0.4s ease;
	}

	.quote-card:hover {
		transform: translateY(-10px);
	}

	.quote-img {
		width: 150px;
		height: 150px;
		border-radius: 50%;
		background: #fff;
		padding: 5px;
		margin-bottom: 20px;
	}

	.quote-img-inner {
		width: 100%;
		height: 100%;
		border-radius: 50%;
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	}

	.quote-text {
		font-size: 1.1rem;
		line-height: 1.8;
		font-style: italic;
	}

	.section-title {
		font-weight: 700;
		margin-bottom: 50px;
	}

	.tags-container {
		text-align: center;
	}

	.expertise-tag {
		display: inline-block;
		padding: 10px 18px;
		margin: 6px;
		background: #eee;
		border-radius: 25px;
		cursor: pointer;
		transition: 0.3s;
	}

	.expertise-tag:hover {
		background: #4e73df;
		color: #fff;
	}

	.expertise-tag.active {
		background: #e91e63;
		color: #fff;
	}

	.quiz-list {
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		margin-top: 40px;
	}

	.quiz-card {
		width: 300px;
		padding: 20px;
		margin: 10px;
		background: #fff;
		border-radius: 10px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
		transition: 0.3s;
	}

	.quiz-card:hover {
		transform: translateY(-5px);
	}

	#quizScrollLeft,
    #quizScrollRight {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 20;
        width: clamp(34px, 4vw, 50px);
        height: clamp(34px, 4vw, 50px);
        border-radius: 50%;
        background: #fff;
        border: 1.5px solid #e0e0e0;
        color: #1c1c1c;
        font-size: clamp(0.72rem, 1.1vw, 0.9rem);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s, border-color 0.2s, transform 0.2s ease, box-shadow 0.2s, opacity 0.2s, visibility 0.2s;
    }

    #quizScrollLeft {
        left: -22px;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    #quizScrollRight {
        right: -22px;
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    #quizScrollLeft:hover,
    #quizScrollRight:hover {
        background: #f5f5f5;
        box-shadow: 0 4px 14px rgba(0,0,0,0.18);
    }

    #quizScrollLeft:active,
    #quizScrollRight:active {
        background: #1c1c1c !important;
        color: #fff !important;
        border-color: #1c1c1c !important;
    }

    #quizScrollLeft.hidden,
    #quizScrollRight.hidden {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    #quizScrollLeft.visible,
    #quizScrollRight.visible {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }
	
	.quiz-filter-sidebar {
		position: sticky;
		top: 80px;
		z-index: 10;
	}
   
	.quiz-filter-sidebar > div {
		max-height: calc(100vh - 40px);
		overflow-y: auto;
	}
	
	@media (min-width: 768px){
		.quiz-filter-sidebar{
			position: sticky;
			top: 80px;
			z-index: 10;
		}

		.quiz-filter-sidebar > div{
			max-height: calc(100vh - 40px);
			overflow-y: auto;
		}
	}

	@media (max-width: 767px){
		.quiz-filter-sidebar{
			position: relative;
			top: 0;
		}
	}
	
	.regions {
		padding: 0px;
		background: #f5f5f5;
		padding-top: 45px;
	}
	
	/* Mobile responsive quiz cards */
@media (max-width: 768px) {

    .quiz-list {
        padding: 10px;
    }

    .quiz-card .col-md-12 {
        padding: 0;
    }

    .region-card {
        border-radius: 14px !important;
        box-shadow: 0 6px 14px rgba(0,0,0,0.08) !important;
    }

    .region-image {
        height: 140px !important;
        border-radius: 14px 14px 0 0;
    }

    .region-content .card {
        border-radius: 16px !important;
    }

    .region-content h6 {
        font-size: 16px;
        white-space: normal !important;
    }

    .card-body {
        padding: 14px 10px;
    }

    .card-body span {
        display: block;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .startQuizBtn {
        width: 100%;
        margin-top: 10px;
        padding: 12px;
        font-size: 15px;
    }

    .card-body .text-dark {
        display: inline-block;
        margin-top: 8px;
        font-size: 13px;
        background: #f5f5f5;
        border-radius: 20px;
        padding: 5px 12px;
    }
}

.ribbon {
    position: absolute;
    top: 12px;
    left: -40px;
    transform: rotate(-45deg);
    background: #28a745;
    color: #fff;
    padding: 6px 45px;
    font-size: 12px;
    font-weight: bold;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    z-index: 10;
}
</style>

<section class="hero" id="home">
	<div class="hero-slider">
		<div class="hero-slide"></div>
		<div class="hero-slide"></div>
		<div class="hero-slide"></div>
	</div>
	<div class="hero-content">
		<div class="hero-subtitle">TEST YOUR KNOWLEDGE</div>
		<h2>TEST InQuizitive {{ date('Y') }} has reached its spectacular Grand Finale!</h2>
		<p>Thanks for your amazing energy – get ready, we’ll return with more excitement soon!</p>
		<a href="{{route('winner.announcement')}}" class="btn-primary">Winner details →</a>
	</div>
</section>

<section class="regions" id="quiz">
	<div class="d-flex justify-content-center align-items-center">
		<h2 class="section-title">All Quizzes, All Effort – Let Your Knowledge Shine! </h2>
	</div>
</section>

<!-- main content -->
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3" style="background-color:#eaf1ff;">
                <div class="quiz-filter-sidebar mt-3 mb-3">
                    <div style="background:#eaf1ff; border:1px solid #e91e77; border-radius:10px; padding:16px;height:auto;">
                        <div style="display:flex; gap:6px; margin-bottom:10px;">
                            <a class="small-box-footer refresh_quiz_data" style="cursor:pointer;">
                                Refresh List
                            </a>
                        </div>

                        <input type="text" id="searchBox" placeholder="Search Quiz" class="searchBox" style="width:100%; padding:10px; border-radius:8px; border:1px solid #b6ccff; margin-bottom:10px;">

                        <select class="difficulty_level"
                            style="width:100%;padding:8px; border-radius:6px; border:1px solid #d0ddff; margin-bottom:10px;">
                            <option value="">Select Level</option>
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>

                        <input type="text" class="search_question"
                            placeholder="Number of Question"
                            style="width:100%; padding:8px; border-radius:6px; border:1px solid #d0ddff;">
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div style="position:relative; display:flex; align-items:center; min-height:300px;">
                    <button id="quizScrollLeft">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="regions-grid quizContainer" style="overflow:hidden; width:100%;"></div>
                    <button id="quizScrollRight">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                </div>
				<div class="promo-card reveal visible mt-5">
					<img style="height: 210px;width: 100%;border-radius: 15px;" class="quiz_banner" src="https://defenders.topscripts.in/quiz-app/public/assets/images/quiz_banner/Quiz app promotion with cheerful mascot.png" alt="Book Promotion Banner" loading="lazy">
				</div>
            </div>

        </div>
    </div>
</section>
<!-- ==================================About Section ================================================ -->
<!--<section class="about" id="about">
        <div class="about-content">
            <div class="about-text">
                <p style="font-size: 0.9rem; letter-spacing: 2px; color: #000; margin-bottom: 1rem;">ABOUT INQUIZITIVE</p>
                <h2>A journey into the world of knowledge where curiosity drives competition</h2>
                <p>Welcome to an exciting learning initiative for high students! This program is designed to inspire curiosity, encourage quizzing, and help students explore, question, and grow. With a focus on knowledge, innovation, and critical thinking, it aims to empower young minds to stay ahead and embrace the future with confidence.</p>
                <p>For years, quizzing has been recognized as a powerful tool to strengthen understanding, foster creativity, and keep students updated with the latest ideas and technological trends.</p>
            </div>
            <div class="about-logo">
                <div style="font-size: 3rem; font-weight: bold;">QUIZ InQuizitive</div>
            </div>
        </div>
    </section> -->
<section class="about py-5 bg-light" id="about">
	<div class="container">
		<div class="row align-items-stretch">

			<!-- Left Content -->
			<div class="col-lg-6 d-flex">
				<div class="w-100 h-100 p-4">
					<p class="text-uppercase text-primary fw-bold small mb-2">About InQuizitive</p>
					<h2 class="fw-bold mb-3">Where Knowledge Meets Competition 🚀</h2>
					<p class="text-muted">
						InQuizitive is more than just a quiz app — it’s a platform where
						curiosity turns into confidence and knowledge transforms into achievement.
					</p>
					<p class="text-muted">
						Sharpen your mind, improve accuracy, and boost your competitive spirit
						with exciting quizzes and live leaderboards.
					</p>
					<a href="#quiz" class="btn btn-primary mt-auto px-4">Start Your Journey</a>
				</div>
			</div>

			<div class="col-lg-6 d-flex">
				<div class="card shadow-lg border-0 w-100 h-100 text-center d-flex justify-content-center">
					<div class="card-body d-flex flex-column justify-content-center">
						<h1 class="fw-bold text-primary display-5">QUIZ</h1>
						<h3 class="fw-bold">InQuizitive</h3>
						<p class="text-muted mt-3">Challenge Yourself. Climb the Leaderboard. Become a Champion 🏆</p>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<div class="promo-card reveal visible m-5">
	<img style="height: 210px;width: 100%;border-radius: 15px;" class="quiz_banner" src="https://defenders.topscripts.in/quiz-app/public/assets/images/quiz_banner/Quiz app promotion with friendly robot.png" alt="Book Promotion Banner" loading="lazy">
</div>
<!--===================================================Quote Section==================================================-->
<section class="quote-section text-center">
	<div class="container">
		<h2 class="section-title" data-aos="fade-down">Leadership Message</h2>
		<div class="row justify-content-center">
			<div class="col-lg-10">
				{{-- Dynamic VP card will be injected here --}}
				<div class="vp_quote_container"></div>
			</div>
		</div>
	</div>
</section>

<!-- Quiz Masters Section -->
<section class="quiz-masters">
	<h2 class="section-title">Meet our Quiz Masters</h2>
	{{-- Dynamic quiz master cards will be injected here --}}
	<div class="masters-grid quizmasters_container"></div>
</section>
<!-- Expertise Tags Cloud -->
<section class="expertise">
	<div>
		<div class="expertise-cloud">
			<h3 style="text-align: center; margin-bottom: 2rem; font-size: 1.8rem;">Quiz Categories</h3>
			<div class="tags-container"></div>
		</div>
	</div>
</section>

<!--  Quiz List Section  -->
<section class="quiz-list"></section>

<div class="promo-card reveal visible m-5">
	<img style="height: 210px;width: 100%;border-radius: 15px;" class="quiz_banner" src="https://defenders.topscripts.in/quiz-app/public/assets/images/quiz_banner/Valentine's Day quiz app promo.png" alt="Book Promotion Banner" loading="lazy">
</div>

<section class="snapshots">
	<h2 class="section-title">Top Performer Snapshots</h2>
	<div class="snapshots-grid snapshotContainer"></div>
</section>

<script>
	$(document).ready(function() {
		$('.expertise-tag').click(function() {
			showLoader();
			$('.expertise-tag').removeClass('active');
			$(this).addClass('active');
			var category = $(this).data('category');

			if (category == "all") {
				hideLoader();
				$('.quiz-card').fadeIn(200);
			} else {
				hideLoader();
				$('.quiz-card').hide();
				$('.quiz-card[data-category="' + category + '"]').fadeIn(200);
			}
		});

		loadSnapshotTopScorers();

		function loadSnapshotTopScorers() {
			$.ajax({
				url: "{{ route('dashboard.content') }}",
				type: "POST",
				data: {
					_token: "{{ csrf_token() }}"
				},
				success: function(response) {
					let html = '';

					if (response.status && response.top_scorers.length > 0) {

						response.top_scorers.slice(0, 3).forEach(function(scorer, index) {

							var profileImage = "https://ui-avatars.com/api/?name=" + encodeURIComponent(scorer.name) + "&size=200&background=random";
							if (scorer.image) {
								profileImage = "{{ asset('assets/images/profile_images') }}/" + scorer.image;
							}

							let gradients = [
								'linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%)',
								'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
								'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'
							];

							let bgStyle = gradients[index % gradients.length];

							html += `
								<div class="snapshot-card">
									<div class="snapshot-image" style="background: url('${profileImage}') center/cover, ${bgStyle};"></div>
									<div class="snapshot-info">
										<h3 class="snapshot-name">${scorer.name}</h3>
										<p>${scorer.description ?? 'Outstanding performance in the quiz competition.'}</p>
									</div>
								</div>
							`;
						});

					} else {
						html = `<p style="text-align:center;color:#999;">No Snapshots Available</p>`;
					}

					$('.snapshotContainer').html(html);
				},
				error: function() {
					$('.snapshotContainer').html(
						`<p style="text-align:center;color:red;">Failed to load snapshots</p>`
					);
				}
			});
		}

		//=============================Load Categories ==============================
		quizCategoryData();

		function quizCategoryData() {
			showLoader();
			$.get("{{ route('quiz.category.data') }}").done(function(response) {
				let categoriesHtml = '';
				console.log('start category response');
				console.log(response);
				console.log('end category response');

				if (response.status && response.data.length > 0) {
					response.data.forEach(category => {

						// ✅ Only show category if quizzes exist
						if (category.quizzes && category.quizzes.length > 0) {

							categoriesHtml += `
								<span class="expertise-tag" 
									data-category="${category.id}" 
									data-category-name="${category.name}">
									
									<span style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 4px;">
										${category.name.toUpperCase()}
									</span>
								</span>
							`;
						}
					});
				} else {
					categoriesHtml = '';
				}

				$('.tags-container').html(categoriesHtml);
				loadQuizListCards(response);
				hideLoader();

			}).fail(function(err) {
				hideLoader();
				console.error('Category fetch error', err);
				$('.tags-container').html('');
			});
		}

		// ==================== quiz-list Section ==============================
		function loadQuizListCards(categoryResponse) {
			let quizListHtml = '';

			if (categoryResponse.status && categoryResponse.data.length > 0) {
				categoryResponse.data.forEach(category => {
					if (category.quizzes && category.quizzes.length > 0) {
						category.quizzes.forEach(quiz => {

							var startdate = getFormatDate(quiz.start_date);
							var enddate = getFormatDate(quiz.end_date);
							var q_title = quiz.quiz_title || 'Quiz Title';
							var shortText = q_title.substring(0, 18);

							var img_url = "{{ asset('assets/images/quiz_images/quiz_default_image.webp') }}";
							if (quiz.quiz_image) {
								img_url = "{{ asset('assets/images/quiz_images') }}/" + quiz.quiz_image;
							}

							let totalQuestions = quiz.questions ? quiz.questions.length : 0;

							quizListHtml += `
							<div class="quiz-card" data-category="${category.id}">
							    <div class="ribbon">${quiz.timer || 240} Second</div>
								<div class="col-md-12 mb-4">
									<div class="region-card" data-quiz_duration="${quiz.timer || ''}" data-quiz_image="${quiz.quiz_image || ''}" data-start_date="${quiz.start_date}" data-end_date="${quiz.end_date}" data-total_questions="${quiz.total_questions}" data-id="${quiz.id}" data-quiz="${quiz.quiz_title}" data-level="${quiz.difficulty}" style="border: 1px solid rgb(224, 224, 224); border-radius: 12px; overflow: hidden; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; font-family: Arial, sans-serif;">
										<div class="region-image" style="height:120px; background:url('${img_url}') center/cover no-repeat;"></div>
										<div class="region-content">
											<div class="d-flex justify-content-center mt-1">
												<div class="card shadow-sm" style="width: 100%;border-radius: 20px;overflow: hidden;">
													<div class="text-center py-1" style="background: linear-gradient(90deg, #ff758c, #ff7eb3); color: white;">
														<h6 class="fw-bold mb-1">${shortText}</h6>
													</div>
													<div class="card-body text-center">
														<div>
															<i class="text-primary"></i>
															<span>Questions: ${quiz.total_questions}</span>
														</div>
														<p style="font-size: x-small;color: #ff0439;">
															${startdate}<strong> To </strong> ${enddate}
														</p>
														
														<a data-id="${quiz.id}" class="btn btn-gradient startQuizBtn fw-bold" style="background: linear-gradient(90deg, #ff758c, #ff7eb3); color: white; border-radius: 50px; padding: 10px 30px;">Start Quiz</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							`;
						});
					}
				});
			}

			if (quizListHtml === '') {
				quizListHtml = '<p style="text-align:center;color:#999;padding:40px 0;">No quizzes available</p>';
			}

			$('.quiz-list').html(quizListHtml);
			$('.quiz-card').hide();
		}

		$(document).on('click', '.expertise-tag', function() {
			showLoader();
			$('.expertise-tag').removeClass('active');
			$(this).addClass('active');

			var categoryId = $(this).data('category');
			var categoryName = $(this).data('category-name');

			$('.selected_category').val(categoryId);
			if (categoryId == 'all') {
				$('.quiz-card').fadeIn(300);
				hideLoader();
			} else {
				$('.quiz-card').hide();
				$('.quiz-card[data-category="' + categoryId + '"]').fadeIn(300);
				hideLoader();
			}
		});

		$(document).on('click', '.startQuizBtn', function(e) {
			e.preventDefault();

			@if(Auth::check())
			//showToaster('success' , 'User logged in → redirect to quiz page!');
			//startQuiz();
			var id = $(this).data('id');
			var url = '{{ route("start.quiz", ["id" => ":id"]) }}';
			url = url.replace(':id', id);
			window.location = url;

			@else
			showToaster('error', 'Please login first to start the quiz!');
			setTimeout(function() {
				window.location = 'login';
			}, 1000);
			@endif
		});

		/* function startQuiz(){
			$.ajax({
				url: "{{ route('start.quiz.by.user') }}",
				type: "POST",
				data: {
					userid: '{{ Auth::id() }}',
					quizid: $('.quizid').val(),
					quizLevel: $('.quizLevel').val(),
					quizName: $('.quizName').val(),
					id: '',
					_token: "{{ csrf_token() }}"
				},
				success: function(response) {
					console.log(response);
				},
				error: function(xhr) {
					hideLoader();
					console.log(xhr.responseText);
				}
			});
		} */

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
		$(window).on('resize', function() {
			handleMenuView();
		});

		$('#mobileNavBtn').on('click', function() {
			$('#mobileNav').addClass('active').fadeIn(200);
		});

		$('#mobileNavClose, .mobile-nav-link').on('click', function() {
			$('#mobileNav').removeClass('active').fadeOut(200);
		});

		var data = [
			"Easy",
			"Medium",
			"Hard",
			"Photos & Images",
			"PDF Documents",
			"Forms",
			"Invoices",
			"User Profiles",
			"Project Files",
			"Design Assets",
			"Reports",
			"Tutorials",
			"Quizzes",
			"Assignments",
			"Projects",
			"Guides",
			"Exercises",
			"Notes",
			"Reference Materials",
			"Tips & Tricks"
		];

		$("#searchBox").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#suggestions").empty();

			if (value !== "") {
				var filtered = data.filter(item =>
					item.toLowerCase().includes(value)
				);

				if (filtered.length > 0) {
					$("#suggestions").show();
					filtered.forEach(function(item) {
						$("#suggestions").append(
							'<div style="padding:10px 14px; cursor:pointer; font-size:14px;">' + item + '</div>'
						);
					});
				} else {
					$("#suggestions").hide();
				}
			} else {
				$("#suggestions").hide();
			}
		});

		$(document).on("click", "#suggestions div", function() {
			$("#searchBox").val($(this).text());
			$("#suggestions").hide();
		});

		$(document).click(function(e) {
			if (!$(e.target).closest("#searchBox, #suggestions").length) {
				$("#suggestions").hide();
			}
		});


		$(document).on('click', '.refresh_quiz_data', function() {
			quizData();
			quizCategoryData();
		});

		$('.searchBox, .difficulty_level, .search_question').on('change', function() {
			quizData();
		});
//======================== SCROLL BUTTONS ==============================

		function updateScrollButtons() {
			var row = document.getElementById('quizScrollRow');
			if (!row) {
				$('#quizScrollLeft').removeClass('visible').addClass('hidden');
				$('#quizScrollRight').removeClass('visible').addClass('hidden');
				return;
			}
			if (row.scrollLeft <= 0) {
				$('#quizScrollLeft').removeClass('visible').addClass('hidden');
			} else {
				$('#quizScrollLeft').removeClass('hidden').addClass('visible');
			}

			if (row.scrollLeft + row.clientWidth >= row.scrollWidth - 5) {
				$('#quizScrollRight').removeClass('visible').addClass('hidden');
			} else {
				$('#quizScrollRight').removeClass('hidden').addClass('visible');
			}
		}

		$('#quizScrollLeft').on('click', function() {
			var row = document.getElementById('quizScrollRow');
			if (row) {
				row.scrollBy({ left: -280, behavior: 'smooth' });
				setTimeout(updateScrollButtons, 350);
			}
		});

		$('#quizScrollRight').on('click', function() {
			var row = document.getElementById('quizScrollRow');
			if (row) {
				row.scrollBy({ left: 280, behavior: 'smooth' });
				setTimeout(updateScrollButtons, 350);
			}
		});

		quizData();

		function quizData() {
			$('.quizStartContainer').html('');
			showLoader();

			var keywords = $('.searchBox').val();
			var difficulty = $('.difficulty_level').val();
			var search_question = $('.search_question').val();

			$.ajax({
				url: "{{ route('quiz.data.for.user') }}",
				type: "POST",
				data: {
					keywords: keywords,
					difficulty: difficulty,
					question: search_question,
					_token: "{{ csrf_token() }}"
				},
				success: function(response) {
					hideLoader();
					if (response.status) {
						let html = '';

						if (response.data.length === 0) {
							html = `<p style="text-align:center;color:#999;">No quiz found</p>`;
							$('#quizScrollLeft, #quizScrollRight').removeClass('visible').addClass('hidden');
						} else {

							html += `<div class="quiz-row" id="quizScrollRow" style="display:flex; flex-wrap:nowrap; overflow-x:auto; gap:15px; padding:10px; scrollbar-width:none;">`;

							response.data.forEach(function(quiz) {
								var startdate = getFormatDate(quiz.start_date);
								var enddate = getFormatDate(quiz.end_date);
								var q_title = quiz.quiz_title;
								var shortText = q_title.substring(0, 18);

								var img_url = "{{ asset('assets/images/quiz_images/quiz_default_image.webp') }}";
								if (quiz.quiz_image) {
									img_url = "{{ asset('assets/images/quiz_images') }}/" + quiz.quiz_image;
								}
								let totalQuestions = quiz.questions ? quiz.questions.length : 0;

								html += `
								<div style="flex:0 0 auto; min-width:250px;">
									<div class="region-card" data-quiz_duration="${quiz.timer}" data-quiz_image="${quiz.quiz_image}" data-start_date="${quiz.start_date}" data-end_date="${quiz.end_date}" data-total_questions="${totalQuestions}" data-id="${quiz.id}" data-quiz="${quiz.quiz_title}" data-level="${quiz.difficulty}" style="border:1px solid #e0e0e0; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1); font-family:Arial, sans-serif;">
										<div class="region-image" style="height:120px; background:url('${img_url}') center/cover no-repeat;"></div>
										<div class="region-content">
											<div class="d-flex justify-content-center mt-1">
												<div class="card shadow-sm" style="width: 100%;border-radius: 20px;overflow: hidden;">
													<div class="text-center py-1" style="background: linear-gradient(90deg, #ff758c, #ff7eb3); color: white;">
														<h6 class="fw-bold mb-1">${shortText}</h6>
													</div>
													<div class="card-body text-center">
														<div><i class="text-primary"></i><span>Questions: ${totalQuestions}</span></div>
														<div><i class="text-success"></i><span>Duration: ${quiz.timer} Second</span></div>
														<div><i class="text-success"></i><span style="font-size: small;">Start: ${startdate}</span></div>
														<div><i class="text-success"></i><span style="font-size: small;">End: ${enddate}</span></div>
														<a data-id="${quiz.id}" class="btn btn-gradient startQuizBtn fw-bold" style="background: linear-gradient(90deg, #ff758c, #ff7eb3); color: white; border-radius: 50px; padding: 10px 30px;">Start Quiz</a>
														<span class="text-dark px-3 py-2 mt-3">${quiz.difficulty}</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>`;
							});

							html += `</div>`;
						}

						$('.quizContainer').html(html);
						setTimeout(function() {
							updateScrollButtons();
							var row = document.getElementById('quizScrollRow');
							if (row) {
								row.addEventListener('scroll', function() {
									updateScrollButtons();
								});
							}
						}, 100);
					}
				},
				error: function(xhr) {
					hideLoader();
					console.log(xhr.responseText);
				}
			});
		}

//<---=============== QuizMasters ================================-->
		loadQuizMasters();

		function loadQuizMasters() {
			$.get("{{ route('quizmaster.data') }}")
				.done(function(response) {

					let vpHtml = '';
					let mastersHtml = '';

					if (response.length === 0) {
						vpHtml = '';
						mastersHtml = '<p style="text-align:center;color:#999;">No Quiz Masters available</p>';
					} else {

						let vpCount = 0;
						let masterCount = 0;

						response.forEach(function(qm) {
							var photoUrl = "https://ui-avatars.com/api/?name=" +
								encodeURIComponent(qm.name) +
								"&size=200&background=random";
							if (qm.photo) {
								photoUrl = "{{ asset('assets/images/quizmaster') }}/" + qm.photo;
							}
							var shortBio = qm.bio ?
								qm.bio.substring(0, 120) + (qm.bio.length > 120 ? '...' : '') :
								'';

							if (qm.role === 'Vice President' && vpCount < 1) {
								vpCount++;
								vpHtml += `
								<div class="quote-card" data-aos="zoom-in" data-aos-duration="1000">
									<div class="row align-items-center">
										<div class="col-md-4 text-center text-dark" data-aos="fade-right">
											<div class="quote-img mx-auto">
												<div class="quote-img-inner"
													style="background: url('${photoUrl}') center/cover no-repeat;">
												</div>
											</div>
											<h4 class="fw-bold mt-3">${qm.name}</h4>
											<p class="small">
												Vice President <br>
												<strong>QUIZ InQuizitive</strong>
											</p>
										</div>
										<div class="col-md-8 text-start" data-aos="fade-left">
											<p class="quote-text">"${qm.bio ?? ''}"</p>
										</div>
									</div>
								</div>`;
							}

							if (qm.role === 'Quiz Master' && masterCount < 2) {
								masterCount++;
								mastersHtml += `
								<div class="master-card">
									<div class="master-image"
										style="background: url('${photoUrl}') center/cover no-repeat;">
									</div>
									<h3 class="master-name">${qm.name}</h3>
									<p class="master-title">QUIZ MASTER</p>
									<p class="master-bio">${shortBio}</p>
								</div>`;
							}
						});
					}


					$('.vp_quote_container').html(
						vpHtml || '<p style="text-align:center;color:#999;">No Vice President data available</p>'
					);

					$('.quizmasters_container').html(
						mastersHtml || '<p style="text-align:center;color:#999;">No Quiz Masters available</p>'
					);
				})
				.fail(function() {
					$('.vp_quote_container').html(
						'<p style="text-align:center;color:red;">Failed to load data</p>'
					);
					$('.quizmasters_container').html(
						'<p style="text-align:center;color:red;">Failed to load data</p>'
					);
				});
		}


		$(document).on('click', '.region-card', function() {
			$('.region-card')
				.css('border', '1px solid #e0e0e0')
				.data('selected', false)
				.each(function() {
					if ($(this).data('original')) {
						$(this).html($(this).data('original'));
					}
				});

			$(this).data('selected', true);
			$(this).css('border', '2px solid #e91e77');

			let quizName = $(this).data('quiz');
			let level = $(this).data('level');
			let quizid = $(this).data('id');
			let total_questions = $(this).data('total_questions');
			let end_date = $(this).data('end_date');
			let start_date = $(this).data('start_date');
			let quiz_image = $(this).data('quiz_image');
			let quiz_duration = $(this).data('quiz_duration');

			$('.quizName').val(quizName);
			$('.quizLevel').val(level);
			$('.quizid').val(quizid);

			$(this).html(getQuizHTML(quizName, level, total_questions, quizid, start_date, end_date, quiz_image , quiz_duration));
		});


		$(document).on('mouseenter', '.region-card', function() {
			if (!$(this).data('original')) {
				$(this).data('original', $(this).html());
			}

			if ($(this).data('selected')) return;

			$('.region-card').css('border', '1px solid #e0e0e0');
			$(this).css('border', '2px solid #e91e77');

			let quizid = $(this).data('id');
			let quizName = $(this).data('quiz');
			let level = $(this).data('level');
			let total_questions = $(this).data('total_questions');
			let end_date = $(this).data('end_date');
			let start_date = $(this).data('start_date');
			let quiz_image = $(this).data('quiz_image');
			let quiz_duration = $(this).data('quiz_duration');

			$(this).html(getQuizHTML(quizName, level, total_questions, quizid, start_date, end_date, quiz_image ,quiz_duration));
		});


		$(document).on('mouseleave', '.region-card', function() {
			if ($(this).data('selected')) return;
			$(this).css('border', '1px solid #e0e0e0');
			$(this).html($(this).data('original'));
		});


		function getQuizHTML(quizName, level, total_questions, quizid, start_date, end_date, quiz_image , quiz_duration) {
			var startdate = getFormatDate(start_date);
			var enddate = getFormatDate(end_date);

			var img_url = "{{ asset('assets/images/quiz_images/quiz_default_image.webp') }}";
			if (quiz_image) {
				img_url = "{{ asset('assets/images/quiz_images') }}/" + quiz_image;
			}

			return `
				<div class="quiz-start-card" style="padding:10px;border-radius:12px;box-shadow:0 6px 20px rgba(0,0,0,0.15);font-family:Arial, sans-serif;background:#fff;text-align:center;">
					<h6 style="color:#e91e77; margin-bottom:5px;">${quizName}</h6>
					<span style="font-size:16px; color:#555;">Difficulty: <strong>${level}</strong></span><br>
					<span style="font-size:16px; color:#555;">Questions: <strong>${total_questions}</strong></span><br>
					<span style="font-size:15px;color:#555;">Duration: <strong>${quiz_duration} second</strong></span>
					<p style="font-size:14px;color:#777;">
						<strong>Start:</strong> ${startdate}<br>
						<strong>End:</strong> ${enddate}
					</p>
					<hr style="margin:5px 0;"> 
					<div style="background-image: url('${img_url}');background-size: cover;background-position: center;background-repeat: no-repeat;height:120px;border-radius:12px;display:flex;flex-direction:column;justify-content:center;align-items:center;color:#fff;text-shadow: 0 1px 3px rgba(0,0,0,0.6);padding:10px;">
						<button class="startQuizBtn ultra-btn" data-id="${quizid}" style="padding:12px 30px;background:#e91e77;color:#fff;border:none;border-radius:25px;font-size:16px;cursor:pointer;">Start Quiz</button>
					</div>
				</div>
			`;
		}

		function getFormatDate(date) {
			var date = new Date(date);
			var options = {
				year: 'numeric',
				month: 'short',
				day: 'numeric',
				//hour: 'numeric',
				//minute: 'numeric',
				//hour12: true      
			};
			var humanReadable = date.toLocaleString('en-US', options);
			return humanReadable;
		}

	});
</script>

@endsection