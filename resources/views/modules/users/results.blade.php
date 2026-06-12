@extends('layouts.user_dashboard')

@section('title', 'My Result')
@section('page-title', 'My Result')
@section('breadcrumb', 'My Result')

@section('content')

<style>
    .result-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    .badge-pass {
        background-color: #198754;
        color: white;
        font-size: 14px;
        padding: 8px 15px;
        border-radius: 6px;
    }
    .badge-fail {
        background-color: #dc3545;
        color: white;
        font-size: 14px;
        padding: 8px 15px;
        border-radius: 6px;
    }
    .score-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
    }
    .progress {
        height: 8px;
    }
    .footer-text {
        font-size: 13px;
        color: gray;
    }
    .quiz-sub-item {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 8px 12px;
        margin-bottom: 6px;
        font-size: 13px;
    }
</style>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            <i class="fas fa-history me-2"></i> My Result
                        </h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2 m-0">
                    <div class="table-responsive mt-3">
                        <div id="resultLoader" class="text-center py-5" style="display:none;">
                            <i class="fas fa-spinner fa-spin fa-2x text-dark"></i>
                        </div>
                        <div id="resultContent" style="display:none;">
                            <div class="result-card p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="text-primary mb-1 result-name">-</h5>
                                        <small>Email: <span class="result-email">-</span></small><br>
                                        <small>Exam Date: <span class="result-date">-</span></small>
                                    </div>
                                    <div>
                                        <i class="fas fa-sync refresh_Result cursor-pointer" title="Refresh"></i>
                                        <span class="result-qualified-badge"></span>
                                    </div>
                                </div>

                                <hr>
                                <div class="row text-center mb-4">
                                    <div class="col-md-4 score-box mb-2">
                                        <h6>Total Score</h6>
                                        <h3 class="text-success result-total-score">0 / 0</h3>
                                        <small>Overall Percentage: <span class="result-percentage">0</span>%</small>
                                    </div>
                                    <div class="col-md-4 score-box mb-2">
                                        <h6>Performance Level</h6>
                                        <h4 class="text-primary result-performance">-</h4>
                                        <small class="result-performance-note">-</small>
                                    </div>
                                    <div class="col-md-4 score-box mb-2">
                                        <h6>Result Status</h6>
                                        <h4 class="result-status-text">-</h4>
                                        <small class="result-status-note">-</small>
                                    </div>
                                </div>
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-layer-group me-1"></i> Section-wise Performance
                                </h6>
                                <div id="sectionWiseContainer"></div>
                                <div class="text-center mt-4">
                                    <button class="btn btn-outline-secondary px-4" onclick="window.print()">
                                        <i class="fas fa-print me-1"></i> Print
                                    </button>
                                </div>

                                <hr>
                                <div class="text-center footer-text">
                                    &copy;{{ date('Y') }} QUIZ APP
                                </div>

                            </div>
                        </div>

                         <div id="resultEmpty" style="display:none;" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>No quiz attempts found. Please attempt a quiz first.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function () {
        loadResult();
        $(document).on('click', '.refresh_Result', function () {
            loadResult();
        });
        function loadResult() {
            showLoader();

            $.ajax({
                url: "{{ route('user.result.data') }}",
                type: "GET",
                success: function (response) {
                    hideLoader();

                    if (!response.status || response.total_possible === 0) {
                        $('#resultEmpty').show();
                        return;
                    }

                    $('.result-name').text(response.user_name);
                    $('.result-email').text(response.user_email);
                    $('.result-date').text(response.exam_date);

                    if (response.qualified) {
                        $('.result-qualified-badge').html(
                            `<span class="badge-pass">QUALIFIED</span>`
                        );
                    } else {
                        $('.result-qualified-badge').html(
                            `<span class="badge-fail">NOT QUALIFIED</span>`
                        );
                    }

                    $('.result-total-score').text(
                        response.total_obtained + ' / ' + response.total_possible
                    );
                    $('.result-percentage').text(response.percentage);

                    $('.result-performance').text(response.performance);
                    let perfNote = '';
                    if (response.performance === 'Advanced') {
                        perfNote = 'Above Average Performance';
                    } else if (response.performance === 'Intermediate') {
                        perfNote = 'Average Performance';
                    } else {
                        perfNote = 'Needs Improvement';
                    }
                    $('.result-performance-note').text(perfNote);

                    if (response.qualified) {
                        $('.result-status-text').html(`<span class="text-success">PASS</span>`);
                        $('.result-status-note').text('Eligible for Next Round');
                    } else {
                        $('.result-status-text').html(`<span class="text-danger">FAIL</span>`);
                        $('.result-status-note').text('Not Eligible for Next Round');
                    }

                    let sectionHtml = '';
                    if (response.section_wise && response.section_wise.length > 0) {
                        response.section_wise.forEach(function (section) {

                            let barColor = 'bg-danger';
                            if (section.percentage >= 80) {
                                barColor = 'bg-success';
                            } else if (section.percentage >= 60) {
                                barColor = 'bg-info';
                            } else if (section.percentage >= 40) {
                                barColor = 'bg-warning';
                            }

                            let quizItems = '';
                            section.quizzes.forEach(function (quiz) {
                                quizItems += `
                                    <div class="quiz-sub-item d-flex justify-content-between">
                                        <span>
                                            <i class="fas fa-chevron-right text-muted me-1"></i>
                                            ${quiz.quiz_title}
                                            <small class="text-muted ms-2">(${quiz.date})</small>
                                        </span>
                                        <span class="font-weight-bold">${quiz.score} / ${quiz.total}</span>
                                    </div>
                                `;
                            });

                            sectionHtml += `
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="font-weight-bold text-uppercase">
                                            ${section.category}
                                        </span>
                                        <span class="font-weight-bold">
                                            ${section.obtained} / ${section.possible}
                                            <small class="text-muted ms-1">(${section.percentage}%)</small>
                                        </span>
                                    </div>
                                    <div class="progress mb-2">
                                        <div class="progress-bar ${barColor}"
                                            style="width: ${section.percentage}%">
                                        </div>
                                    </div>
                                    ${quizItems}
                                </div>
                            `;
                        });
                    } else {
                        sectionHtml = `<p class="text-muted">No section data found.</p>`;
                    }

                    $('#sectionWiseContainer').html(sectionHtml);
                    $('#resultContent').show();
                },
                error: function (xhr) {
                    $('#resultLoader').hide();
                    $('#resultEmpty').show();
                    console.error('Result load failed:', xhr);
                }
            });
        }
});
</script>

@endsection