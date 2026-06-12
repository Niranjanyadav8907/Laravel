@extends('layouts.admin')

@section('title', 'Quiz')
@section('page-title', 'Quiz Add')
@section('breadcrumb', 'Quiz Add') 

@section('content')


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<style>
/* ── Bulk delete bar ── */
#quiz_bulk_delete_bar {
    display: none;
    align-items: center;
    gap: 10px;
    background: #fff5fb;
    border: 1.5px solid #f0c0dd;
    border-radius: 6px;
    padding: 7px 14px;
    margin-bottom: 10px;
}
#quiz_bulk_delete_bar span {
    font-size: 13px;
    font-weight: 600;
    color: #c0156e;
}
#quiz_bulk_delete_bar button {
    background: #e91e8c;
    border: none;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    padding: 5px 16px;
    border-radius: 5px;
    text-transform: uppercase;
    letter-spacing: .4px;
    cursor: pointer;
    transition: background .2s;
}
#quiz_bulk_delete_bar button:hover { background: #c4186f; }

/* checkbox style */
.quiz-checkbox, #select_all_quizzes {
    width: 16px;
    height: 16px;
    accent-color: #e91e8c;
    cursor: pointer;
}

/* ── FIX: blank column issue ── */
.quizTable th:first-child,
.quizTable td:first-child {
    width: 30px !important;
    min-width: 30px !important;
    max-width: 30px !important;
}
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Quiz List</h6>
                    </div>
                </div>
                
                <div class="card-body px-0 pb-2 m-4">
                    <div class="table-responsive">
                        <i class="fas fa-sync refresh_quiz cursor-pointer"></i>&nbsp;&nbsp;
                        <i class="fas fa-plus create_new_quiz_modal_button cursor-pointer"></i>

                        <!-- Bulk Delete Bar -->
                        <div id="quiz_bulk_delete_bar">
                            <span id="quiz_bulk_selected_count">0 selected</span>
                            <button id="quiz_bulk_delete_btn"><i class="fas fa-trash me-1"></i> Delete Selected</button>
                        </div>

                        <table class="table quizTable align-items-center mb-0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2" style="width:30px;">
                                        <input type="checkbox" id="select_all_quizzes" title="Select All">
                                    </th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Quiz Title</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Category/Questions</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Difficulty</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Action</th>
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

<div class="modal fade" id="createQuizModal" tabindex="-1" aria-labelledby="createQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createQuizModalLabel">Add New Quiz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="add_quiz_form" enctype="multipart/form-data"> 
                    @csrf 
                    <input type="hidden" name="quiz_id" id="quiz_id" value="">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Quiz Title</label>
                                <input type="text" class="form-control" name="quiz_title" id="quiz_title" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text quiz_title_error"></small>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Category</label>
								<input type="text" class="form-control" name="category_input" id="category_input" placeholder="Type category...">
								<input type="hidden" name="category_id" id="category_id">
								<div id="category_suggestions" class="list-group position-absolute w-100 shadow" style="z-index:1000; display:none;margin-top:37px;"></div>
                            </div>
                            <small class="text-danger error-text category_id_error"></small>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Quiz Description</label>
                                <textarea class="form-control" name="quiz_description" id="quiz_description" rows="3" onfocus="focused(this)" onfocusout="defocused(this)"></textarea>
                            </div>
                            <small class="text-danger error-text quiz_description_error"></small>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Difficulty</label>
                                <select class="form-control" name="difficulty" id="difficulty" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="">Select Difficulty</option>
                                    <option value="Easy">Easy</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Hard">Hard</option>
                                </select>
                            </div>
                            <small class="text-danger error-text difficulty_error"></small>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Total Questions</label>
                                <input type="number" class="form-control" name="total_questions" id="total_questions" min="1" onfocus="focused(this)" onfocusout="defocused(this)" disabled>
                            </div>
                            <small class="text-danger error-text total_questions_error"></small>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" id="status" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="">Select Status</option>
                                    <option value="Draft" selected>Draft</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <small class="text-danger error-text status_error"></small>
                        </div>
						<div class="col-md-6 mb-2">
							<div class="input-group input-group-outline is-focused is-filled">
								<label class="form-label">Quiz Date & Time</label>
								<input type="text" id="quiz_dates" class="form-control" placeholder="Select start & end date & time" readonly>
							</div>
							<small class="text-danger error-text dates_error"></small>
						</div>
						<div class="col-md-6 mb-2">
							<div class="input-group input-group-outline is-focused is-filled">
								<label class="form-label">Time (Seconds)</label>
								<input type="number" class="form-control" name="timer" id="timer" placeholder="e.g. 300" min="1" step="1">
							</div>
						</div>
						<div class="col-md-6 mt-3">
							<div class="input-group input-group-outline is-focused is-filled" style="display:none;">
								<label class="form-label">Quiz Image</label>
								<input type="file" class="form-control" name="quiz_image" id="quiz_image" accept="image/*">
							</div>
							<img data-toggle="tooltip" title="Click To Update Quiz Image!" src="" style="width:50%;height:120px; display:none;" class="img-thumbnail quiz_image_preview cursor-pointer">
							<small class="text-danger error-text quiz_image_error"></small>
						</div>
					</div>

					<input type="hidden" name="start_date" id="start_date">
					<input type="hidden" name="end_date" id="end_date">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary create_new_quiz">Save Quiz</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="quizImageModal" tabindex="-1" aria-labelledby="createQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title mb-0" id="createQuizModalLabel">Quiz Image</h5>
                <button type="button" class="btn-close bg-dark ms-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="quiz_image_container text-center m-1">
                <img src="https://defenders.topscripts.in/quiz-app/public/assets/images/quiz_images/1769762388_697c6e54847f9.jpg"  class="img-fluid rounded quiz_image_src" alt="Quiz Image" style="width: 100%;height: 400px;">
            </div>
        </div>
    </div>
</div>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
(function($) {
	$('.quiz_image_preview').click(function() {
		$('#quiz_image').click();
	});
	$('#quiz_image').on('change', function(e) {
		const file = this.files[0];
		const $preview = $('.quiz_image_preview');

		if (file && file.type.startsWith('image/')) {
			const reader = new FileReader();
			reader.onload = function(ev) {
				$preview.attr('src', ev.target.result).show();
			};
			reader.readAsDataURL(file);
		} else {
			$preview.attr('src', '').hide();
		}
	});


	$(function () {
		$('#quiz_dates').daterangepicker({
			timePicker: true,
			timePicker24Hour: true,
			timePickerSeconds: false,
			autoUpdateInput: false,

			drops: 'up',        
			opens: 'left',       

			locale: {
				format: 'YYYY-MM-DD HH:mm'
			}
		});

		$('#quiz_dates').on('apply.daterangepicker', function (ev, picker) {
			$(this).val(
				picker.startDate.format('YYYY-MM-DD HH:mm') +
				' - ' +
				picker.endDate.format('YYYY-MM-DD HH:mm')
			);

			$('#start_date').val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
			$('#end_date').val(picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
		});

		$('#quiz_dates').on('cancel.daterangepicker', function () {
			$(this).val('');
			$('#start_date').val('');
			$('#end_date').val('');
		});
	});

    $(document).ready(function() {
        $('.content_header').hide();
        // ✅ Bootstrap 5 Modal variables 
        var createQuizModal = new bootstrap.Modal(document.getElementById('createQuizModal'));
        var quizImageModal  = new bootstrap.Modal(document.getElementById('quizImageModal'));

        // ── FIX: shared DataTable config to avoid duplication ──
        var dtConfig = {
            responsive: true,
            autoWidth: false,
            columnDefs: [
                { width: '30px', targets: 0 }
            ],
            columns: [
                { orderable: false, searchable: false },
                { orderable: true },
                { orderable: true },
                { orderable: false, searchable: false },
                { orderable: false, searchable: false },
                { orderable: false, searchable: false }
            ],
            pageLength: 10,
            order: [[1, 'asc']]
        };

        var quizTable = $('.quizTable').DataTable(dtConfig);
    
        // ========== Add New Quiz Button Click ==========
        $('.create_new_quiz_modal_button').on('click', function() {
            resetForm(); 
			$('#category_suggestions').hide();
			var img_url = "{{ asset('assets/images/quiz_images/quiz_default_image.webp') }}";
            $('.quiz_image_preview').attr('src', img_url).show();
            $('#createQuizModalLabel').text('Add New Quiz');
            $('.create_new_quiz').text('Save Quiz');
            createQuizModal.show(); 
        });
        
        // ========== Edit Quiz Button Click ==========
        $(document).on('click', '.edit_quiz', function() {
			$('#category_suggestions').hide();
            var quizImage = $(this).data('image');
            
            $('.error-text').text('');
            $('#quiz_id').val($(this).data('id'));
            $('#quiz_title').val($(this).data('title'));
            $('#quiz_description').val($(this).data('description'));
            //$('#category_input').val($(this).data('category'));
            $('#difficulty').val($(this).data('difficulty'));
            $('#total_questions').val($(this).data('questions'));
            $('#status').val($(this).data('status'));
            $('#start_date').val($(this).data('start'));
            $('#end_date').val($(this).data('end'));
            $('#timer').val($(this).data('timer'));
            $('#existing_image').val(quizImage);
			
            if(quizImage) {
				var img_url = "{{ asset('assets/images/quiz_images/') }}"+"/"+quizImage;
				$('.quiz_image_preview').attr('src', img_url).show();
            } else {
				var img_url = "{{ asset('assets/images/quiz_images/quiz_default_image.webp') }}";
                $('.quiz_image_preview').attr('src', img_url).show();
            }
			
			var categoryId = $(this).data('category');
			$('#category_id').val(categoryId); 
			let selectedCategory = categoryList.find(cat => cat.id == categoryId);

			if (selectedCategory) {
				$('#category_input').val(selectedCategory.name);
			} else {
				$('#category_input').val('');
			}
       
            $('.add_quiz_form').find('input, textarea, select').each(function () {
                if($(this).val()) {
                    focused(this);
                }
            });
            
            $('#createQuizModalLabel').text('Update Quiz');
            $('.create_new_quiz').text('Update Quiz');
            createQuizModal.show();
        });
        

        $(document).on('click', '.create_new_quiz', function () {
            showLoader();

            let form = document.querySelector('.add_quiz_form');
            let formData = new FormData(form);

            $('.error-text').text('');

            $.ajax({
                url: "{{ route('add.quiz.ajax') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.create_new_quiz').text('Please wait...').prop('disabled', true);
                },success: function (response) {
                    hideLoader();
                    if (response.status) {
                        showToaster('success', response.message);
                        resetForm();
                        createQuizModal.hide(); 
                        quizData();
                    } else {
                        showToaster('error', response.message);
                    }
                },

                error: function (xhr) {
                    hideLoader();
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('.' + key + '_error').text(value[0]);
                        });
                    } else {
                        showToaster('error', 'Something went wrong!');
                    }
                },

                complete: function () {
                    $('.create_new_quiz')
                        .text($('#quiz_id').val() ? 'Update Quiz' : 'Save Quiz')
                        .prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.refresh_quiz', function () {
            quizData();
        });
        
        $('#end_date').on('change', function() {
            var startDate = $('#start_date').val();
            var endDate = $(this).val();
            
            if(startDate && endDate) {
                if(new Date(endDate) <= new Date(startDate)) {
                    $('.end_date_error').text('End date must be after start date');
                    $(this).val('');
                    defocused(this);
                } else {
                    $('.end_date_error').text('');
                }
            }
        });
		
		quizData();
		let categoryList = [];
		
		function quizData() {
			showLoader();

			$.get("{{ route('quiz.data') }}").done(function (response) {
				let rows = '';
				console.log(response);
				var quizzes = response.quizzes;
				
				quizzes.forEach(quiz => {
					const description = quiz.quiz_description ? quiz.quiz_description.substring(0, 30) + '...' : '-';
					let totalQuestions = quiz.questions ? quiz.questions.length : 0;
					
					var img_url = "{{ asset('assets/images/quiz_images/quiz_default_image.webp') }}";
					if(quiz.quiz_image){
						var img_url = "{{ asset('assets/images/quiz_images') }}"+"/"+quiz.quiz_image;
					}
					
					rows += `
					<tr>
						<td>
							<input type="checkbox" class="quiz-checkbox" value="${quiz.id}">
						</td>
						<td>
						  <div class="d-flex align-items-center">
							<img src="${img_url}" class="me-3 cursor-pointer quizimage rounded" width="50" height="50" alt="Quiz Image">
							<div>
							  <h6 class="mb-0 text-sm">${quiz.quiz_title}</h6>
							  <p class="text-xs text-secondary mb-0">
								${description}
							  </p>
                              ${quiz.quiz_planner ? `
                                <p class="text-xs text-success mb-0">
                                    Schedule ${moment(quiz.quiz_planner).format('DD MMM YYYY, hh:mm A')}
                                </p>
                                ` : ``}
							</div>

						  </div>
						</td>
						<td>
							<div class="d-flex align-items-center">
								<div>
								  <h6 class="mb-0 text-sm">${quiz.category?.name ?? ' '}</h6>
								  <p class="text-xs text-secondary mb-0">
									Questions: ${totalQuestions}
								  </p>
								</div>
							</div>
						</td>
						<td><div class="input-group input-group-outline is-filled">${difficultyUI(quiz.difficulty, quiz.id)}</div></td>
						<td><div class="input-group input-group-outline is-filled">${statusUI(quiz.status, quiz.id)}</div></td>
						<td>
							<i class="fas fa-edit text-info cursor-pointer edit_quiz"
							   data-id="${quiz.id}"
							   data-title="${quiz.quiz_title}"
							   data-description="${quiz.quiz_description ?? ''}"
							   data-category="${quiz.category_id}"
							   data-difficulty="${quiz.difficulty}"
							   data-questions="${totalQuestions}"
							   data-status="${quiz.status}"
							   data-start="${quiz.start_date ?? ''}"
							   data-end="${quiz.end_date ?? ''}"
							   data-timer="${quiz.timer ?? ''}"
							   data-image="${quiz.quiz_image ?? ''}">
							</i>
							<i class="fas fa-trash text-danger cursor-pointer delete_quiz" data-id="${quiz.id}"></i>
						</td>
					</tr>`;
				});

                quizTable.destroy();
				$('.quizTable tbody').html(rows);
                // ── FIX: use same dtConfig so columns are always consistent ──
                quizTable = $('.quizTable').DataTable(dtConfig);
				
				categoryList = response.categories;

                // Reset checkboxes & bulk bar after reload
                $('#select_all_quizzes').prop('checked', false);
                updateQuizBulkBar();
				
				hideLoader();
			})
			.fail(function (err) {
				hideLoader();
				console.error('Quiz fetch error', err);
			});
		}

        // ========================== CHECKBOX / BULK DELETE LOGIC ==========================

        // Select All
        $(document).on('change', '#select_all_quizzes', function () {
            var checked = $(this).is(':checked');
            $('.quizTable tbody input.quiz-checkbox').prop('checked', checked);
            updateQuizBulkBar();
        });

        // Individual checkbox change
        $(document).on('change', '.quiz-checkbox', function () {
            var total   = $('.quizTable tbody input.quiz-checkbox').length;
            var checked = $('.quizTable tbody input.quiz-checkbox:checked').length;
            $('#select_all_quizzes').prop('checked', total > 0 && total === checked);
            updateQuizBulkBar();
        });

        function updateQuizBulkBar() {
            var count = $('.quizTable tbody input.quiz-checkbox:checked').length;
            if (count > 0) {
                $('#quiz_bulk_selected_count').text(count + ' selected');
                $('#quiz_bulk_delete_bar').css('display', 'flex');
            } else {
                $('#quiz_bulk_delete_bar').css('display', 'none');
            }
        }

        // Bulk Delete button
        $(document).on('click', '#quiz_bulk_delete_btn', function () {
            var ids = [];
            $('.quizTable tbody input.quiz-checkbox:checked').each(function () {
                ids.push($(this).val());
            });
            if (!ids.length) return;

            Swal.fire({
                title: 'Delete ' + ids.length + ' quiz' + (ids.length > 1 ? 'zes' : '') + '?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete!'
            }).then(function (result) {
                if (!result.isConfirmed) return;

                showLoader();
                var token  = "{{ csrf_token() }}";
                var done   = 0;
                var failed = 0;

                function deleteNext(index) {
                    if (index >= ids.length) {
                        hideLoader();
                        quizData();
                        var msg = done + ' quiz' + (done !== 1 ? 'zes' : '') + ' deleted successfully!';
                        if (failed > 0) msg += ' ' + failed + ' failed.';
                        showToaster('success', msg);
                        return;
                    }
                    $.ajax({
                        url: "{{ route('quiz.delete') }}",
                        type: 'POST',
                        data: { id: ids[index], _token: token },
                        success : function (res) { if (res.status) done++; else failed++; },
                        error   : function ()    { failed++; },
                        complete: function ()    { deleteNext(index + 1); }
                    });
                }

                deleteNext(0);
            });
        });
		
		
		$('#category_input').on('keyup', function () {
			let keyword = $(this).val().toLowerCase();
			let suggestions = '';

			if (keyword.length === 0) {
				$('#category_suggestions').hide();
				return;
			}

			let filtered = categoryList.filter(cat =>
				cat.name.toLowerCase().includes(keyword)
			);

			if (filtered.length > 0) {
				filtered.forEach(cat => {
					suggestions += `
						<a href="#" 
						   class="list-group-item list-group-item-action category-item"
						   data-id="${cat.id}"
						   data-name="${cat.name}">
						   ${cat.name}
						</a>`;
				});

				$('#category_suggestions').html(suggestions).show();
			} else {
				$('#category_suggestions').hide();
			}
		});
		
		$(document).on('click', '.category-item', function (e) {
			e.preventDefault();

			let name = $(this).data('name');
			let id = $(this).data('id');

			$('#category_input').val(name);  // visible text
			$('#category_id').val(id);       // hidden id

			$('#category_suggestions').hide();
		});
		
		$(document).on('click', '.quizimage', function () {
			var imgSrc = $(this).attr('src');
			$('.quiz_image_src').attr('src', imgSrc);
			quizImageModal.show(); 
		});

		
		function difficultyUI(difficulty, id) {
			const colors = {Easy: 'success',Medium: 'warning',Hard: 'danger'};

			let options = ['Easy', 'Medium', 'Hard'].map(d => `<option ${d === difficulty ? 'selected' : ''}>${d}</option>`).join('');

			return `
				<select 
					class="form-control update_difficulty border-top-2 border-${colors[difficulty]}" 
					data-id="${id}"
					style="border-top: 2px solid;"
				>
					${options}
				</select>
			`;
		}

		function statusUI(status, id) {
			const colors = {Draft: 'secondary',Active: 'success',Inactive: 'danger'};

			let options = ['Draft', 'Active', 'Inactive'].map(s => `<option ${s === status ? 'selected' : ''}>${s}</option>`).join('');

			return `
				<select class="form-control update_status border-${colors[status]}" data-id="${id}" style="border-top: 2px solid var(--bs-${colors[status]});">
					${options}
				</select>
			`;
		}
        
        $(document).on('click', '.delete_quiz', function () {
            var id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure delete this quiz?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();

                    $.ajax({
                        url: "{{ route('quiz.delete') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            hideLoader();
                            showToaster('success', response.message);
                            quizData(); 
                        },
                        error: function () {
                            hideLoader();
                            Swal.fire(
                                'Error!',
                                'Something went wrong during deletion.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
                                    
        $(document).on('change', '.update_difficulty', function () {
            let difficulty = $(this).val();
            let id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to change the difficulty of this quiz!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();

                    $.ajax({
                         url: "{{route('difficulty.status.update')}}", 
                        type: "POST",
                        data: {
                            difficulty: difficulty,
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            hideLoader();
                            if (response.status) {
                                showToaster('success', response.message);
                                quizData(); 
                            } else {
                                showToaster('error', response.message);
                            }
                        },
                        error: function () {
                            hideLoader();
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                } else {
                  
                    $(this).val($(this).data('prev'));
                }
            });
        });

        $(document).on('change', '.update_status', function () {
            let status = $(this).val();
            let id = $(this).data('id');
            let $this = $(this);

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to change the status of this quiz!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();

                    $.ajax({
                        url: "{{route('update.status')}}", 
                        type: "POST",
                        data: {
                            id: id,
                            status: status,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            hideLoader();
                            if (response.status) {
                                showToaster('success', response.message);
                                quizData();
                            } else {
                                showToaster('error', response.message);
                                $this.val($this.data('prev'));
                            }
                        },
                        error: function () {
                            hideLoader();
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                            $this.val($this.data('prev'));
                        }
                    });
                } else {
                    $this.val($this.data('prev'));
                }
            });
        });

        $(document).on('focus', '.update_status', function () {
            $(this).data('prev', $(this).val());
        });

        function resetForm() {
            $('.add_quiz_form')[0].reset();
            $('#quiz_id').val('');
            $('.error-text').text('');
            
            $('.add_quiz_form').find('input, textarea, select').each(function () {
                defocused(this);
            });
        }
        
    });
})(jQuery);
</script>

@endsection