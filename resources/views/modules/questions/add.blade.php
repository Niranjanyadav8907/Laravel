@extends('layouts.admin')
@section('title', 'Questions')
@section('page-title', 'Questions')
@section('breadcrumb', 'Questions') 

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<style>
/* ── Match existing modal input style (pink/red outline on focus) ── */
#csvUploadModal .input-group-outline .form-control,
#csvUploadModal .input-group-outline select.form-control {
    border: 1.5px solid #ced4da;
    border-radius: 6px;
    padding: 10px 12px;
    font-size: 14px;
    transition: border-color .2s;
    background: #fff;
    width: 100%;
}
#csvUploadModal .input-group-outline .form-control:focus,
#csvUploadModal .input-group-outline select.form-control:focus {
    border-color: #e91e8c;
    outline: none;
    box-shadow: none;
}
#csvUploadModal .form-label-custom {
    font-size: 12px;
    color: #e91e8c;
    font-weight: 500;
    margin-bottom: 4px;
    display: block;
}
#csvUploadModal .field-wrap {
    border: 1.5px solid #ced4da;
    border-radius: 6px;
    padding: 10px 12px;
    position: relative;
    margin-bottom: 4px;
    transition: border-color .2s;
}
#csvUploadModal .field-wrap:focus-within {
    border-color: #e91e8c;
}
#csvUploadModal .field-wrap label {
    position: absolute;
    top: -9px;
    left: 10px;
    background: #fff;
    padding: 0 4px;
    font-size: 11px;
    color: #e91e8c;
    font-weight: 500;
}
#csvUploadModal .field-wrap select,
#csvUploadModal .field-wrap input[type="file"] {
    border: none;
    outline: none;
    width: 100%;
    font-size: 14px;
    background: transparent;
    padding: 2px 0;
}
/* format info box */
#csvUploadModal .format-box {
    border: 1px solid #f0c0dd;
    background: #fff5fb;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 13px;
    color: #555;
    margin-bottom: 16px;
}
#csvUploadModal .format-box code {
    background: #fde8f4;
    border-radius: 4px;
    padding: 2px 6px;
    font-size: 12px;
    color: #c0156e;
}
/* Preview table */
#csv_preview_table th {
    background: #3a3a3a;
    color: #fff;
    font-size: 12px;
    font-weight: 500;
    white-space: nowrap;
}
#csv_preview_table td {
    font-size: 12px;
    vertical-align: middle;
}
/* Buttons — match existing pink/dark style */
.btn-csv-primary {
    background: #e91e8c;
    border: none;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .5px;
    padding: 8px 20px;
    border-radius: 6px;
    text-transform: uppercase;
    transition: background .2s;
}
.btn-csv-primary:hover { background: #c4186f; color:#fff; }
.btn-csv-secondary {
    background: #6c757d;
    border: none;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .5px;
    padding: 8px 20px;
    border-radius: 6px;
    text-transform: uppercase;
}
.btn-csv-secondary:hover { background: #5a6268; color:#fff; }
.btn-csv-outline {
    background: transparent;
    border: 1.5px solid #e91e8c;
    color: #e91e8c;
    font-size: 12px;
    font-weight: 500;
    padding: 6px 14px;
    border-radius: 6px;
}
.btn-csv-outline:hover { background:#fde8f4; }
/* progress bar */
#csv_progress_wrap { display:none; margin-top:10px; }
#csv_progress_bar  { height:6px; border-radius:4px; background:#e91e8c; width:0; transition:width .3s; }

/* ── Bulk delete bar ── */
#bulk_delete_bar {
    display: none;
    align-items: center;
    gap: 10px;
    background: #fff5fb;
    border: 1.5px solid #f0c0dd;
    border-radius: 6px;
    padding: 7px 14px;
    margin-bottom: 10px;
}
#bulk_delete_bar span {
    font-size: 13px;
    font-weight: 600;
    color: #c0156e;
}
#bulk_delete_bar button {
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
#bulk_delete_bar button:hover { background: #c4186f; }

/* checkbox style */
.question-checkbox, #select_all_questions {
    width: 16px;
    height: 16px;
    accent-color: #e91e8c;
    cursor: pointer;
}

/* ── FIX: blank column issue ── */
.questionsTable th:first-child,
.questionsTable td:first-child {
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
                        <h6 class="text-white text-capitalize ps-3">Questions List</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2 m-4">
                    <div class="table-responsive">
                        <i class="fas fa-sync refresh_questions cursor-pointer" title="Refresh"></i>&nbsp;&nbsp;
                        <i class="fas fa-plus create_new_question_modal_button cursor-pointer" title="Add Question"></i>&nbsp;&nbsp;
                        <i class="fas fa-file-csv upload_csv_modal_button cursor-pointer" style="color:#e91e8c;" title="Upload CSV"></i>

                        <!-- Bulk Delete Bar -->
                        <div id="bulk_delete_bar">
                            <span id="bulk_selected_count">0 selected</span>
                            <button id="bulk_delete_btn"><i class="fas fa-trash me-1"></i> Delete Selected</button>
                        </div>

                        <table class="questionsTable table align-items-center mb-0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2" style="width:30px;">
                                        <input type="checkbox" id="select_all_questions" title="Select All">
                                    </th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Question Text</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Quiz Title</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Question Type</th>
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


<!-- =========================== Modal ==========================-->

<div class="modal fade" id="createQuestionModal" tabindex="-1" aria-labelledby="createQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createQuestionModalLabel">Add New Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="add_question_form">
                    @csrf
                    <input type="hidden" name="question_id" id="question_id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-outline my-1 is-focused is-filled">
                                <label class="form-label">Select Quiz</label>
                                <select class="form-control" name="quiz_id" id="quiz_id" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="">Select Quiz</option>
                                    @foreach($quizzes as $quiz)
                                        <option value="{{ $quiz->id }}">{{ $quiz->quiz_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="text-danger error-text quiz_id_error"></small>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-outline my-1 is-focused is-filled">
                                <label class="form-label">Question Type</label>
                                <select class="form-control" name="question_type" id="question_type" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="mcq">Multiple Choice</option>
                                </select>
                            </div>
                            <small class="text-danger error-text question_type_error"></small>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-outline my-1">
                                <label class="form-label">Question Text</label>
                                <textarea class="form-control" name="question_text" id="question_text" rows="3" onfocus="focused(this)" onfocusout="defocused(this)"></textarea>
                            </div>
                            <small class="text-danger error-text question_text_error"></small>
                        </div>
                        <div class="col-md-12" id="options_section">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group input-group-outline my-1">
                                        <label class="form-label">Option 1</label>
                                        <input type="text" class="form-control" name="option_1" id="option_1" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                    <small class="text-danger error-text option_1_error"></small>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-outline my-1">
                                        <label class="form-label">Option 2</label>
                                        <input type="text" class="form-control" name="option_2" id="option_2" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                    <small class="text-danger error-text option_2_error"></small>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-outline my-1">
                                        <label class="form-label">Option 3</label>
                                        <input type="text" class="form-control" name="option_3" id="option_3" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                    <small class="text-danger error-text option_3_error"></small>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-outline my-1">
                                        <label class="form-label">Option 4</label>
                                        <input type="text" class="form-control" name="option_4" id="option_4" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                    <small class="text-danger error-text option_4_error"></small>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group input-group-outline my-1">
                                        <label class="form-label">Correct Answer</label>
                                        <input type="text" class="form-control correct_option" name="correct_option" id="correct_option" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                    <small class="text-danger error-text correct_option_error correct_answer_message"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="display:none;">
                            <div class="input-group input-group-outline my-1">
                                <label class="form-label">Marks</label>
                                <input type="number" class="form-control" name="marks" id="marks" value="1" min="1">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary create_new_question">Save Question</button>
            </div>
        </div>
    </div>
</div>

<!-- =========================== CSV Upload Modal ==========================-->
<div class="modal fade" id="csvUploadModal" tabindex="-1" aria-labelledby="csvUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="csvUploadModalLabel">Upload Questions via CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="csv_step_1">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <div class="field-wrap">
                                <label>Select Quiz</label>
                                <select id="csv_quiz_id">
                                    <option value="">Select Quiz</option>
                                    @foreach($quizzes as $quiz)
                                        <option value="{{ $quiz->id }}">{{ $quiz->quiz_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="text-danger" id="csv_quiz_error"></small>
                        </div>

                        <!-- Download Sample -->
                        <div class="col-md-6 mb-3 d-flex align-items-center">
                            <a href="{{ asset('sample_questions.csv') }}" download class="btn-csv-outline">
                                <i class="fas fa-download me-1"></i> Download Sample CSV
                            </a>
                        </div>

                    </div>

                    <!-- Format info -->
                    <div class="format-box mb-3">
                        <strong>Required CSV Format</strong> &nbsp;(first row must be header)<br>
                        <code>question_text, option_1, option_2, option_3, option_4, correct_option</code><br>
                        <span style="font-size:12px;color:#888;">
                            The value in <strong>correct_option</strong> must exactly match one of the four option values.
                        </span>
                    </div>

                    <div class="mb-3">
                        <div class="field-wrap">
                            <label>Choose CSV File</label>
                            <input type="file" id="csv_file_input" accept=".csv">
                        </div>
                        <small class="text-danger" id="csv_file_error"></small>
                    </div>

                    <button type="button" class="btn-csv-primary" id="parse_csv_btn">
                        <i class="fas fa-eye me-1"></i> PREVIEW QUESTIONS
                    </button>
                </div>

                <!-- ── STEP 2 : Preview parsed questions ── -->
                <div id="csv_step_2" style="display:none;">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="fw-bold" style="font-size:15px;">Questions Preview</span>&nbsp;
                            <span class="badge" style="background:#28a745;font-size:12px;" id="csv_valid_count">0 Valid</span>
                            <span class="badge ms-1" style="background:#dc3545;font-size:12px;display:none;" id="csv_error_count">0 Errors</span>
                        </div>
                        <button type="button" class="btn-csv-outline" id="csv_back_btn">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </button>
                    </div>

                    <div class="table-responsive" style="max-height:380px;overflow-y:auto;">
                        <table class="table table-sm table-bordered mb-0" id="csv_preview_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Question Text</th>
                                    <th>Option 1</th>
                                    <th>Option 2</th>
                                    <th>Option 3</th>
                                    <th>Option 4</th>
                                    <th>Correct Answer</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="csv_preview_body"></tbody>
                        </table>
                    </div>

                    <!-- Import progress bar -->
                    <div id="csv_progress_wrap">
                        <div style="font-size:12px;color:#888;margin-bottom:4px;" id="csv_progress_label">Importing...</div>
                        <div style="background:#f0f0f0;border-radius:4px;overflow:hidden;">
                            <div id="csv_progress_bar"></div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn-csv-secondary" data-bs-dismiss="modal">CLOSE</button>
                <button type="button" class="btn-csv-primary" id="import_csv_btn" style="display:none;">
                    <i class="fas fa-upload me-1"></i> IMPORT QUESTIONS
                </button>
            </div>

        </div>
    </div>
</div>


<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
(function($) {
    $(document).ready(function () {

        // ── FIX: shared DataTable config to avoid blank column on mobile→desktop switch ──
        var dtConfig = {
            responsive: true,
            autoWidth: false,
            columnDefs: [
                { width: '30px', targets: 0 }
            ],
            columns: [
                { orderable: false, searchable: false },
                { orderable: false },
                { orderable: true  },
                { orderable: true  },
                { orderable: false, searchable: false }
            ],
            pageLength: 10,
            order: [[1, 'asc']]
        };

        var questionsTable = $('.questionsTable').DataTable(dtConfig);

        function checkOptionsFilled() {
            var filled = true;
            $('.form-control[id^="option_"]').each(function () {
                if ($.trim($(this).val()) === '') filled = false;
            });
            if (filled) {
                $('#correct_option').prop('disabled', false);
            } else {
                $('#correct_option').prop('disabled', true).val('');
                $('.create_new_question').prop('disabled', true);
                $('.correct_answer_message').text('');
            }
        }

        $('#option_1, #option_2, #option_3, #option_4').on('keyup change', checkOptionsFilled);

        $('#correct_option').on('input', function () {
            var correctVal = $.trim($(this).val());
            if (correctVal === '') {
                $('.create_new_question').prop('disabled', true);
                $('.correct_answer_message').text('');
                return;
            }
            var matched = false;
            $('#option_1, #option_2, #option_3, #option_4').each(function () {
                if ($.trim($(this).val()) === correctVal) matched = true;
            });
            if (matched) {
                $('.create_new_question').prop('disabled', false);
                $('.correct_answer_message').text('');
            } else {
                $('.create_new_question').prop('disabled', true);
                $('.correct_answer_message').text("Correct answer doesn't match any option.");
            }
        });

        $('.create_new_question_modal_button').on('click', function () {
            resetQuestionForm();
            $('#createQuestionModalLabel').text('Add New Question');
            $('.create_new_question').text('Save Question');
            new bootstrap.Modal(document.getElementById('createQuestionModal')).show();
        });

        $(document).on('change', '#question_type', function () {
            var t = $(this).val();
            if (t === 'True/False') {
                $('#option_1').val('True');  $('#option_2').val('False');
                $('#option_3').val('');      $('#option_4').val('');
                $('#option_3, #option_4').prop('disabled', true);
            } else {
                $('#option_3, #option_4').prop('disabled', false);
                if ($('#option_1').val() === 'True') { $('#option_1').val(''); $('#option_2').val(''); }
            }
        });

        // ===================== Edit question ===================================== 
        $(document).on('click', '.edit_question', function () {
            $('.error-text').text('');
            $('#question_id').val($(this).data('id'));
            $('#quiz_id').val($(this).data('quiz'));
            $('#question_text').val($(this).data('text'));
            $('#question_type').val($(this).data('type'));
            $('#option_1').val($(this).data('option1'));
            $('#option_2').val($(this).data('option2'));
            $('#option_3').val($(this).data('option3'));
            $('#option_4').val($(this).data('option4'));
            $('#correct_option').val($(this).data('correct')).prop('disabled', false);
            $('#marks').val($(this).data('marks'));
            $('#question_type').trigger('change');

            $('.add_question_form').find('input, textarea, select').each(function () {
                if ($(this).val()) focused(this);
            });
            $('.create_new_question').prop('disabled', false);
            $('.correct_answer_message').text('');
            $('#createQuestionModalLabel').text('Update Question');
            $('.create_new_question').text('Update Question');
            new bootstrap.Modal(document.getElementById('createQuestionModal')).show();
        });

        //==============================Save / Update question =========================================
        $(document).on('click', '.create_new_question', function () {
            showLoader();
            $('.error-text').text('');
            $.ajax({
                url: "{{ route('add.question.ajax') }}",
                type: 'POST',
                data: $('.add_question_form').serialize(),
                beforeSend: function () {
                    $('.create_new_question').text('Please wait...').prop('disabled', true);
                },
                success: function (res) {
                    hideLoader();
                    if (res.status) {
                        showToaster('success', res.message);
                        resetQuestionForm();
                        bootstrap.Modal.getInstance(document.getElementById('createQuestionModal')).hide();
                        questionsData();
                    } else {
                        showToaster('error', res.message);
                    }
                },
                error: function (xhr) {
                    hideLoader();
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function (key, val) {
                            $('.' + key + '_error').text(val[0]);
                        });
                    } else {
                        showToaster('error', 'Something went wrong. Please try again.');
                    }
                },
                complete: function () {
                    $('.create_new_question')
                        .text($('#question_id').val() ? 'Update Question' : 'Save Question')
                        .prop('disabled', false);
                }
            });
        });
        $(document).on('click', '.refresh_questions', questionsData);

        //===================================== Single Delete ======================================
        $(document).on('click', '.delete_question', function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Delete this question?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e91e8c',
                cancelButtonColor:  '#6c757d',
                confirmButtonText:  'Yes, delete it!',
                cancelButtonText:   'Cancel'
            }).then(function (result) {
                if (result.isConfirmed) {
                    showLoader();
                    $.ajax({
                        url: "{{ route('question.delete') }}",
                        type: 'POST',
                        data: { id: id, _token: "{{ csrf_token() }}" },
                        success: function (res) {
                            hideLoader();
                            showToaster('success', res.message);
                            questionsData();
                        },
                        error: function () {
                            hideLoader();
                            Swal.fire('Error!', 'Something went wrong during deletion.', 'error');
                        }
                    });
                }
            });
        });

        // ==============================Load questions ============================================
        function questionsData() {
            showLoader();
            $.ajax({
                url: "{{ route('questions.data') }}",
                type: 'GET',
                success: function (response) {
                    hideLoader();
                    var rows = '';
                    $.each(response, function (key, q) {
                        var dateObj    = new Date(q.created_at);
                        var customDate = dateObj.toLocaleString('en-US', { year:'numeric', month:'short', day:'numeric', hour:'2-digit', minute:'2-digit', hour12:true });
                        var qText      = (q.question_text || '').length > 30 ? q.question_text.substring(0,30)+'...' : (q.question_text||'');
                        var cText      = (q.correct_option||'').length > 20 ? q.correct_option.substring(0,20)+'...' : (q.correct_option||'');

                        rows += `
                            <tr>
                                <td>
                                    <input type="checkbox" class="question-checkbox" value="${q.id}">
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-0 text-sm">${qText}</h6>
                                        <p class="text-xs text-secondary mb-0">${customDate}</p>
                                    </div>
                                </td>
                                <td><p class="text-xs font-weight-bold mb-0">${q.quiz_title ?? ''}</p></td>
                                <td>
                                    <div>
                                        <h6 class="mb-0 text-sm">${q.question_type || 'N/A'}</h6>
                                        <p class="text-xs text-secondary mb-0">Answer: ${cText}</p>
                                    </div>
                                </td>
                                <td>
                                    <i data-id="${q.id}" data-quiz="${q.quiz_id}" data-text="${q.question_text}"
                                       data-type="${q.question_type}" data-option1="${q.option_1}" data-option2="${q.option_2}"
                                       data-option3="${q.option_3}" data-option4="${q.option_4}"
                                       data-correct="${q.correct_option}" data-marks="${q.marks}"
                                       class="fas fa-edit edit_question cursor-pointer text-info me-2" style="font-size:16px;"></i>
                                    <i data-id="${q.id}" class="fas fa-trash delete_question cursor-pointer text-danger" style="font-size:16px;"></i>
                                </td>
                            </tr>`;
                    });

                    questionsTable.destroy();
                    $('.questionsTable tbody').html(rows);
                    // ── FIX: use same dtConfig so columns are always consistent ──
                    questionsTable = $('.questionsTable').DataTable(dtConfig);

                    // Reset checkboxes & bulk bar after reload
                    $('#select_all_questions').prop('checked', false);
                    updateBulkBar();
                },
                error: function (xhr) { hideLoader(); console.error('Error fetching questions:', xhr); }
            });
        }

        function resetQuestionForm() {
            $('.add_question_form')[0].reset();
            $('#question_id').val('');
            $('.error-text').text('');
            $('#option_3, #option_4').prop('disabled', false);
            $('.add_question_form').find('input, textarea, select').each(function () { defocused(this); });
        }

        questionsData();

        // ========================== CHECKBOX / BULK DELETE LOGIC ==========================

        // Select All
        $(document).on('change', '#select_all_questions', function () {
            var checked = $(this).is(':checked');
            // Check all visible (current DataTable page) rows
            $('.questionsTable tbody input.question-checkbox').prop('checked', checked);
            updateBulkBar();
        });

        // Individual checkbox change
        $(document).on('change', '.question-checkbox', function () {
            var total   = $('.questionsTable tbody input.question-checkbox').length;
            var checked = $('.questionsTable tbody input.question-checkbox:checked').length;
            $('#select_all_questions').prop('checked', total > 0 && total === checked);
            updateBulkBar();
        });

        function updateBulkBar() {
            var count = $('.questionsTable tbody input.question-checkbox:checked').length;
            if (count > 0) {
                $('#bulk_selected_count').text(count + ' selected');
                $('#bulk_delete_bar').css('display', 'flex');
            } else {
                $('#bulk_delete_bar').css('display', 'none');
            }
        }

        // Bulk Delete button
        $(document).on('click', '#bulk_delete_btn', function () {
            var ids = [];
            $('.questionsTable tbody input.question-checkbox:checked').each(function () {
                ids.push($(this).val());
            });
            if (!ids.length) return;

            Swal.fire({
                title: 'Delete ' + ids.length + ' question' + (ids.length > 1 ? 's' : '') + '?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e91e8c',
                cancelButtonColor:  '#6c757d',
                confirmButtonText:  'Yes, delete!',
                cancelButtonText:   'Cancel'
            }).then(function (result) {
                if (!result.isConfirmed) return;

                showLoader();
                var token  = "{{ csrf_token() }}";
                var done   = 0;
                var failed = 0;

                function deleteNext(index) {
                    if (index >= ids.length) {
                        hideLoader();
                        questionsData();
                        var msg = done + ' question' + (done !== 1 ? 's' : '') + ' deleted successfully!';
                        if (failed > 0) msg += ' ' + failed + ' failed.';
                        showToaster('success', msg);
                        return;
                    }
                    $.ajax({
                        url: "{{ route('question.delete') }}",
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

        // ========================== CSV UPLOAD LOGIC ==================================

        var parsedQuestions = [];

        // Open CSV modal
        $('.upload_csv_modal_button').on('click', function () {
            resetCsvModal();
            new bootstrap.Modal(document.getElementById('csvUploadModal')).show();
        });

        // Back to step 1
        $('#csv_back_btn').on('click', function () { showCsvStep(1); });

        // Preview button
        $('#parse_csv_btn').on('click', function () {
            var quizId = $('#csv_quiz_id').val();
            var file   = $('#csv_file_input')[0].files[0];
            var ok     = true;

            $('#csv_quiz_error, #csv_file_error').text('');

            if (!quizId) { $('#csv_quiz_error').text('Please select a quiz.'); ok = false; }
            if (!file)   { $('#csv_file_error').text('Please choose a CSV file.'); ok = false; }
            if (!ok) return;

            var reader = new FileReader();
            reader.onload = function (e) { parseAndPreviewCSV(e.target.result); };
            reader.readAsText(file);
        });

        function parseAndPreviewCSV(text) {
            var lines = text.split(/\r?\n/).filter(function (l) { return l.trim() !== ''; });

            if (lines.length < 2) {
                showToaster('error', 'No data found in the CSV file. Please check the file and try again.');
                return;
            }

            var headers  = parseCsvLine(lines[0]).map(function (h) { return h.trim().toLowerCase(); });
            var required = ['question_text','option_1','option_2','option_3','option_4','correct_option'];
            var missing  = required.filter(function (c) { return headers.indexOf(c) === -1; });

            if (missing.length > 0) {
                showToaster('error', 'Missing columns in CSV: ' + missing.join(', '));
                return;
            }

            parsedQuestions = [];
            var previewRows = '';
            var validCount  = 0;
            var errorCount  = 0;

            for (var i = 1; i < lines.length; i++) {
                var cols = parseCsvLine(lines[i]);
                var row  = {};
                headers.forEach(function (h, idx) { row[h] = (cols[idx] || '').trim(); });

                var errors = [];
                required.forEach(function (col) {
                    if (!row[col]) errors.push('"' + col + '" is empty');
                });
                if (errors.length === 0) {
                    var opts = [row['option_1'], row['option_2'], row['option_3'], row['option_4']];
                    if (opts.indexOf(row['correct_option']) === -1) {
                        errors.push('Correct answer does not match any of the four options');
                    }
                }

                var statusCell = '';
                if (errors.length === 0) {
                    validCount++;
                    parsedQuestions.push(row);
                    statusCell = '<span class="badge" style="background:#28a745;">Valid</span>';
                } else {
                    errorCount++;
                    statusCell = '<span class="badge" style="background:#dc3545;">Error</span>'
                               + '<br><small class="text-danger">' + errors.join('<br>') + '</small>';
                }

                previewRows += `
                    <tr${errors.length > 0 ? ' class="table-danger"' : ''}>
                        <td>${i}</td>
                        <td>${escHtml(row['question_text'] || '')}</td>
                        <td>${escHtml(row['option_1'] || '')}</td>
                        <td>${escHtml(row['option_2'] || '')}</td>
                        <td>${escHtml(row['option_3'] || '')}</td>
                        <td>${escHtml(row['option_4'] || '')}</td>
                        <td>${escHtml(row['correct_option'] || '')}</td>
                        <td>${statusCell}</td>
                    </tr>`;
            }

            $('#csv_preview_body').html(previewRows);
            $('#csv_valid_count').text(validCount + ' Valid');

            if (errorCount > 0) {
                $('#csv_error_count').text(errorCount + ' Error' + (errorCount > 1 ? 's' : '')).show();
            } else {
                $('#csv_error_count').hide();
            }

            if (validCount > 0) {
                $('#import_csv_btn').show();
            } else {
                $('#import_csv_btn').hide();
                showToaster('error', 'No valid questions found. Please fix the errors in your CSV and try again.');
            }

            showCsvStep(2);
        }

        // ==================== Import valid ==================================== 
        $('#import_csv_btn').on('click', function () {
            if (!parsedQuestions.length) return;

            var quizId  = $('#csv_quiz_id').val();
            var token   = "{{ csrf_token() }}";
            var total   = parsedQuestions.length;
            var done    = 0;
            var failed  = 0;

            $('#import_csv_btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> IMPORTING...');
            $('#csv_progress_wrap').show();
            showLoader();

            function updateProgress() {
                var pct = Math.round(((done + failed) / total) * 100);
                $('#csv_progress_bar').css('width', pct + '%');
                $('#csv_progress_label').text('Importing ' + (done + failed) + ' of ' + total + ' questions...');
            }

            function sendNext(index) {
                if (index >= parsedQuestions.length) {
                    hideLoader();
                    $('#import_csv_btn').prop('disabled', false).html('<i class="fas fa-upload me-1"></i> IMPORT QUESTIONS');
                    $('#csv_progress_wrap').hide();
                    bootstrap.Modal.getInstance(document.getElementById('csvUploadModal')).hide();
                    questionsData();

                    var msg = done + ' question' + (done !== 1 ? 's' : '') + ' imported successfully!';
                    if (failed > 0) msg += ' ' + failed + ' failed.';
                    showToaster('success', msg);
                    return;
                }

                var q = parsedQuestions[index];
                $.ajax({
                    url: "{{ route('add.question.ajax') }}",
                    type: 'POST',
                    data: {
                        _token        : token,
                        quiz_id       : quizId,
                        question_type : 'mcq',
                        question_text : q['question_text'],
                        option_1      : q['option_1'],
                        option_2      : q['option_2'],
                        option_3      : q['option_3'],
                        option_4      : q['option_4'],
                        correct_option: q['correct_option'],
                        marks         : q['marks'] || 1
                    },
                    success : function (res) { if (res.status) done++; else failed++; },
                    error   : function ()    { failed++; },
                    complete: function ()    { updateProgress(); sendNext(index + 1); }
                });
            }

            updateProgress();
            sendNext(0);
        });


        // ================================ Helpers ================================

        function showCsvStep(step) {
            if (step === 1) {
                $('#csv_step_1').show();
                $('#csv_step_2').hide();
                $('#import_csv_btn').hide();
            } else {
                $('#csv_step_1').hide();
                $('#csv_step_2').show();
            }
        }

        function resetCsvModal() {
            $('#csv_quiz_id').val('');
            $('#csv_file_input').val('');
            $('#csv_quiz_error, #csv_file_error').text('');
            $('#csv_preview_body').html('');
            $('#csv_valid_count').text('0 Valid');
            $('#csv_error_count').hide();
            $('#csv_progress_wrap').hide();
            $('#csv_progress_bar').css('width', '0');
            parsedQuestions = [];
            showCsvStep(1);
        }

        /** Parse one CSV line — handles quoted fields and escaped quotes */
        function parseCsvLine(line) {
            var result = [], cur = '', inQ = false;
            for (var i = 0; i < line.length; i++) {
                var ch = line[i];
                if (ch === '"') {
                    if (inQ && line[i+1] === '"') { cur += '"'; i++; }
                    else inQ = !inQ;
                } else if (ch === ',' && !inQ) {
                    result.push(cur); cur = '';
                } else {
                    cur += ch;
                }
            }
            result.push(cur);
            return result;
        }

        /** Escape HTML to prevent XSS in preview table */
        function escHtml(str) {
            return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }

    });
})(jQuery);
</script>

@endsection