@extends('layouts.user_dashboard')
@section('title', 'Quiz History')
@section('page-title', 'Quiz History')
@section('breadcrumb', 'Quiz History')

@section('content')

<style>
    .quiz-card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        background: #fff;
        transition: 0.3s;
    }
    .quiz-card:hover {
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .quiz-title {
        font-weight: 600;
        font-size: 16px;
    }
    .quiz-info p {
        margin: 0;
        font-size: 14px;
    }
    .quiz-footer {
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .view-icon {
        cursor: pointer;
        font-size: 18px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            <i class="fas fa-history me-2"></i> My Quiz History
                        </h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2 m-4">
                    <i class="fas fa-sync refresh_history cursor-pointer" title="Refresh"></i>

                    <div class="table-responsive mt-3">
                        <table class="table quizHistoryTable align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-dark text-sm font-weight-bold">Quiz Details</th>
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

{{-- ============ Detail Modal ============ --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-clipboard-check me-2"></i>
                    <span class="modal-quiz-name">Quiz Detail</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {{-- Score Cards --}}
                <div class="row mb-4">
                    <div class="col-md-4 mb-2">
                        <div class="card text-center py-3 bg-gradient-info shadow-sm">
                            <h4 class="modal-score text-white mb-0">0</h4>
                            <small class="text-white opacity-8">Total Score</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="card text-center py-3 bg-gradient-success shadow-sm">
                            <h4 class="modal-correct text-white mb-0">0</h4>
                            <small class="text-white opacity-8">Correct</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="card text-center py-3 bg-gradient-danger shadow-sm">
                            <h4 class="modal-incorrect text-white mb-0">0</h4>
                            <small class="text-white opacity-8">Incorrect</small>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table detailTable align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Question</th>
                                <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Your Answer</th>
                                <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Correct Answer</th>
                                <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Result</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    loadHistory();

    $(document).on('click', '.refresh_history', function () {
        loadHistory();
    });
    function loadHistory() {
        showLoader();

        $.ajax({
            url: "{{ route('quiz.history.data') }}",
            type: "GET",
            success: function (response) {
                hideLoader();
                let tbody = $('.quizHistoryTable tbody');
                tbody.html('');

                if (!response.status || response.data.length === 0) {
                    tbody.html(`
                        <tr>
                            <td colspan="1" class="text-center text-muted py-3">
                                No quiz attempts found.
                            </td>
                        </tr>
                    `);
                    return;
                }

                let rows = '';
                $.each(response.data, function (index, item) {
                    let messageColor = item.message === 'Time Out' ? 'text-danger' : 'text-success';

                    rows += `
                        <tr>
                            <td>
                                <div class="quiz-card">
                                    <div class="quiz-title">${item.quiz_name}</div>
                                    <div class="quiz-info text-muted mt-2">
                                        <p class="text-success">Start: ${item.started_at}</p>
                                        <p class="text-primary">End: ${item.finished_at}</p>
                                        <p>Score: <strong>${item.score} / ${item.total_questions}</strong></p>
                                        <p>Status: ${statusBadge(item.status)}</p>
                                    </div>
                                    <div class="quiz-footer">
                                        <span class="${messageColor} small">${item.message ?? '-'}</span>
                                        <i class="fas fa-eye text-info view-icon view_detail_btn"
                                           data-id="${item.id}"
                                           title="View Detail">
                                        </i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                });

                tbody.html(rows);
            },
            error: function (xhr) {
                hideLoader();
                console.error('History load failed:', xhr);
                showToaster('error', 'Failed to load quiz history!');
            }
        });
    }

    function statusBadge(status) {
        const map = {
            completed : `<span class="badge bg-gradient-success">Completed</span>`,
            pending   : `<span class="badge bg-gradient-warning text-dark">Pending</span>`,
        };
        return map[status] ?? `<span class="badge bg-gradient-secondary">${status}</span>`;
    }

    $(document).on('click', '.view_detail_btn', function () {
        let attemptId = $(this).data('id');
        showLoader();

        $.ajax({
            url: `/quiz-app/public/quiz-history/detail/${attemptId}`,
            type: "GET",
            success: function (response) {
                hideLoader();

                if (!response.status) {
                    showToaster('error', 'Detail not found!');
                    return;
                }

                $('.modal-quiz-name').text(response.quiz_name);
                $('.modal-score').text(response.score);
                $('.modal-correct').text(response.correct);
                $('.modal-incorrect').text(response.incorrect);

                let detailRows = '';
                $.each(response.answers, function (i, ans) {
                    let resultBadge = ans.is_correct
                        ? `<span class="badge bg-gradient-success">✓ Correct</span>`
                        : `<span class="badge bg-gradient-danger">✗ Wrong</span>`;

                    detailRows += `
                        <tr>
                            <td><p class="text-xs mb-0">${ans.question}</p></td>
                            <td><p class="text-xs mb-0">${ans.selected_option ?? '-'}</p></td>
                            <td><p class="text-xs mb-0">${ans.correct_option ?? '-'}</p></td>
                            <td>${resultBadge}</td>
                        </tr>
                    `;
                });

                $('.detailTable tbody').html(detailRows);
                $('#detailModal').modal('show');
            },
            error: function (xhr) {
                hideLoader();
                console.error('Detail load failed:', xhr);
                showToaster('error', 'Something went wrong!');
            }
        });
    });

});
</script>
@endsection