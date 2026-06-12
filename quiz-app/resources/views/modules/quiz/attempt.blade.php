@extends('layouts.admin')

@section('title', 'Quiz Attempt Monitoring')
@section('page-title', 'Quiz Attempt Monitoring')
@section('breadcrumb', 'Quiz Attempt Monitoring')

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Quiz Attempt Monitoring</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2 m-4">
                    <div class="table-responsive">
                        <i class="fas fa-sync refresh_attempts cursor-pointer me-2" style="font-size:1.3rem;"></i>
                        <table class="table attemptTable align-items-center mb-0"style="width:100%;">
                            <thead>
                                <tr>  
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">User / Quiz</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Score</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Date</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Status / Message</th>
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

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
(function($) {
    $(document).ready(function () {

        // ✅ DataTable initialize
        var attemptTable = $('.attemptTable').DataTable({
            responsive: true,
            columns: [
                { orderable: true },
                { orderable: true },
                { orderable: true },
                { orderable: false, searchable: false }
            ],
            pageLength: 10,
            order: [[0, 'asc']]
        });

        getAttemptData();
        $('.refresh_attempts').on('click', function () {
            getAttemptData();
        });

        function getAttemptData() {
            showLoader();

            $.ajax({
                url: "{{ route('quiz.attempt.data.for.user') }}",
                type: "GET",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (response) {
                    hideLoader();

                    let rows = '';

                    if (!response.status || response.data.length === 0) {
                        rows = `
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No attempts found
                                </td>
                            </tr>
                        `;
                    } else {
                        $.each(response.data, function (index, attempt) {
                            var quiz_title = attempt.quiz ? attempt.quiz.quiz_title : '-';

                            if (quiz_title && quiz_title.length > 20) {
                                quiz_title = quiz_title.substring(0, 20) + '...';
                            }
                            
                            rows += `
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-0 text-sm text-capitalize">${attempt.user ? attempt.user.name : ' '}</h6>
                                            <p class="text-xs text-secondary mb-0">${quiz_title}</p>
                                        </div>
                                    </td>
                                    <td>${attempt.score ?? '-'} </td>
                                    <td>
                                        <div>
                                            <p class="mb-0 text-sm text-success">Started: ${formatDateTime(attempt.started_at)}</p>
                                            <p class="mb-0 text-sm text-primary">Finished: ${formatDateTime(attempt.finished_at)}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">
                                                <span class="badge ${getStatusBadge(attempt.status)}">${attempt.status ?? '-'}</span>
                                            </p>
                                            <p class="mb-0 text-sm text-capitalize">Message: ${attempt.message ?? ' '}</p>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                    }

                    // ✅ destroy → refill → reinitialize
                    attemptTable.destroy();
                    $('.attemptTable tbody').html(rows);
                    attemptTable = $('.attemptTable').DataTable({
                        responsive: true,
                        columns: [
                            { orderable: true },
                            { orderable: true },
                            { orderable: true },
                            { orderable: false, searchable: false }
                        ],
                        pageLength: 10,
                        order: [[0, 'asc']]
                    });
                },
                error: function (xhr) {
                    hideLoader();
                    console.error('Failed to load attempts:', xhr);
                }
            });
        }
        
        function formatDateTime(isoDate) {
            if (!isoDate) return ' ';

            var dateObj = new Date(isoDate);

            var options = { 
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            };

            return dateObj.toLocaleString('en-US', options);
        }

        function getStatusBadge(status) {
            if (!status) return 'bg-secondary';

            const s = status.toLowerCase();

            if (s.includes('complete') || s.includes('finish'))
                return 'bg-success';

            if (s.includes('time out'))
                return 'bg-danger';

            if (s.includes('incomplete'))
                return 'bg-warning';

            return 'bg-secondary';
        }

    });
})(jQuery);
</script>


@endsection