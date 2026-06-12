@extends('layouts.admin')

@section('title', 'Users Quiz Report')
@section('page-title', 'Users Quiz Report')
@section('breadcrumb', 'Users Quiz Report')

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<style>
/* ══════════════════════════════════
   Slip Style — same as print slips
══════════════════════════════════ */
.slip-wrap {
    font-family: Arial, sans-serif;
    background: white;
}

/* Header */
.slip-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 0 10px 0;
    border-bottom: 1px solid #bbb;
    margin-bottom: 12px;
}

.slip-logo { font-size: 20px; font-weight: bold; }
.slip-date { font-size: 13px; color: #555; }
.slip-title {
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 14px;
}

/* Top Section: Info + Photo */
.slip-top {
    display: flex;
    justify-content: space-between;
    margin-bottom: 14px;
}

.slip-info { width: 75%; }

.slip-row { display: flex; margin: 5px 0; font-size: 14px; }
.slip-label { width: 100px; font-weight: bold; color: #333; }
.slip-value { flex: 1; }

.slip-photo {
    width: 120px;
    height: 140px;
    border: 1px solid #000;
    object-fit: cover;
    display: block;
    background: #eee;
}

/* Section Title */
.slip-section {
    font-weight: bold;
    border-bottom: 1px solid #000;
    padding-bottom: 4px;
    margin: 14px 0 8px;
    font-size: 14px;
}

/* Tables */
.slip-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13.5px;
}

.slip-table th {
    background: #eee;
    border: 1px solid #777;
    padding: 6px 8px;
    text-align: left;
}

.slip-table td {
    border: 1px solid #777;
    padding: 6px 8px;
}

/* History table dark header */
.slip-table.dark-head th {
    background: #2c3e50;
    color: white;
}

/* Status badge */
.slip-badge {
    background: #28a745;
    color: white;
    padding: 3px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
    display: inline-block;
    white-space: nowrap;
}

.slip-badge.danger  { background: #dc3545; }
.slip-badge.warning { background: #fd7e14; }

/* Date colors */
.dt-started  { color: green;   font-size: 12px; display: block; }
.dt-finished { color: crimson; font-size: 12px; display: block; }

/* Note */
.slip-note {
    margin-top: 14px;
    font-size: 13px;
    color: #555;
}

.slip-note ul { padding-left: 18px; margin-top: 4px; }

/* Print Button inside modal */
.slip-print-btn {
    margin-top: 16px;
    display: block;
    width: 100%;
    padding: 9px;
    background: #2563eb;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 14px;
    border-radius: 4px;
    transition: background 0.2s;
}

.slip-print-btn:hover { background: #1d4ed8; }

@media print {
    .slip-print-btn { display: none; }
    .slip-badge {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .slip-table.dark-head th {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        background: #2c3e50 !important;
        color: white !important;
    }
}
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Users Quiz Report</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2 m-4">
                    <div class="table-responsive">
                        <i class="fas fa-sync refresh_report cursor-pointer me-2" style="font-size:1.3rem;"></i>
                        <table class="table reportTable align-items-center mb-0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">User</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Email</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Attempts</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Date</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Total Score</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Points</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2" style="min-width:180px;">Actions</th>
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

<!-- ===================== MODAL: View Result ===================== -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-gradient-dark">
        <h5 class="modal-title text-white" id="resultModalLabel">User Result</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="resultModalBody">
        <div class="text-center py-4"><div class="spinner-border text-dark"></div></div>
      </div>
    </div>
  </div>
</div>

<!-- ===================== MODAL: Quiz History ===================== -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h5 class="modal-title text-white" id="historyModalLabel">User Quiz History</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="historyModalBody">
        <div class="text-center py-4"><div class="spinner-border text-info"></div></div>
      </div>
    </div>
  </div>
</div>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
(function ($) {
    $(document).ready(function () {

        // ✅ Bootstrap 5 Modal variables
        var resultModal  = new bootstrap.Modal(document.getElementById('resultModal'));
        var historyModal = new bootstrap.Modal(document.getElementById('historyModal'));

        var reportTable = $('.reportTable').DataTable({
            responsive: true,
            columns: [
                { orderable: true },
                { orderable: true },
                { orderable: true },
                { orderable: true },
                { orderable: true },
                { orderable: true },
                { orderable: true },
                { orderable: false, searchable: false }
            ],
            pageLength: 10,
            order: [[0, 'asc']]
        });

        getReportData();

        $('.refresh_report').on('click', function () {
            getReportData();
        });

        function getReportData() {
            showLoader();
            $.ajax({
                url: "{{ route('user.quiz.report.data') }}",
                type: "GET",
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (response) {
                    hideLoader();
                    let rows = '';

                    if (!response.status || response.data.length === 0) {
                        rows = `<tr><td colspan="8" class="text-center text-muted">No data found</td></tr>`;
                    } else {
                        $.each(response.data, function (i, u) {
                            rows += `
                            <tr>
                                <td><h6 class="mb-0 text-sm text-capitalize">${u.name ?? '-'}</h6></td>
                                <td><p class="text-xs text-secondary mb-0">${u.email ?? '-'}</p></td>
                                <td><span class="badge bg-secondary">${u.quiz_attempts ?? 0}</span></td>
                                <td>
                                    <p class="mb-0 text-sm text-success">Started: ${u.started_at}</p>
                                    <p class="mb-0 text-sm text-primary">Finished: ${u.finished_at}</p>
                                </td>
                                <td><strong>${u.highest_score} / ${u.total_points}</strong></td>
                                <td><span class="badge bg-dark">${u.total_points ?? 0}</span></td>
                                <td><span class="badge ${u.status === 'Qualified' ? 'bg-success' : 'bg-danger'}">${u.status}</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm me-1 btn-view-result" data-id="${u.user_id}">
                                        <i class="fas fa-poll me-1"></i>Result
                                    </button>
                                    <button class="btn btn-info btn-sm btn-view-history" data-id="${u.user_id}">
                                        <i class="fas fa-history me-1"></i>History
                                    </button>
                                </td>
                            </tr>`;
                        });
                    }

                    reportTable.destroy();
                    $('.reportTable tbody').html(rows);
                    reportTable = $('.reportTable').DataTable({
                        responsive: true,
                        columns: [
                            { orderable: true },
                            { orderable: true },
                            { orderable: true },
                            { orderable: true },
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
                    console.error('Failed to load report:', xhr);
                }
            });
        }

        // ─── Result Modal ──────────────────────────────────────────────
        $(document).on('click', '.btn-view-result', function () {
            var userId = $(this).data('id');
            $('#resultModalBody').html('<div class="text-center py-4"><div class="spinner-border text-dark"></div></div>');
            resultModal.show();

            $.ajax({
                url: "{{ url('user/quiz-report/result') }}/" + userId,
                type: "GET",
                success: function (res) {
                    if (!res.status) {
                        $('#resultModalBody').html('<p class="text-center text-muted p-3">No data found.</p>');
                        return;
                    }

                    var today = new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });

                    // User image — actual ya fallback
                    var userImg = res.user_image
                        ? res.user_image
                        : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(res.user_name) + '&size=200&background=cccccc&color=333';

                    var statusText  = res.qualified ? 'Qualified' : 'Not Qualified';
                    var passColor   = res.qualified ? 'green' : 'red';

                    var attemptsRows = '';
                    $.each(res.attempts, function (i, a) {
                        attemptsRows += `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${a.quiz_title}</td>
                            <td>${a.category}</td>
                            <td><strong>${a.score} / ${a.total}</strong></td>
                            <td>${a.date}</td>
                        </tr>`;
                    });

                    $('#resultModalLabel').text(res.user_name + ' — Result');
                    $('#resultModalBody').html(`
                        <div class="slip-wrap p-3">

                            <!-- Slip Header -->
                            <div class="slip-header">
                                <div class="slip-logo">Assessment Portal</div>
                                <div class="slip-date">Printed On : ${today}</div>
                            </div>

                            <!-- Title -->
                            <div class="slip-title">Candidate Assessment Result</div>

                            <!-- Top: Info + Photo -->
                            <div class="slip-top">
                                <div class="slip-info">
                                    <div class="slip-row">
                                        <div class="slip-label">Name</div>
                                        <div class="slip-value">${res.user_name}</div>
                                    </div>
                                    <div class="slip-row">
                                        <div class="slip-label">Email</div>
                                        <div class="slip-value">${res.user_email}</div>
                                    </div>
                                    <div class="slip-row">
                                        <div class="slip-label">Level</div>
                                        <div class="slip-value">${res.performance}</div>
                                    </div>
                                    <div class="slip-row">
                                        <div class="slip-label">Status</div>
                                        <div class="slip-value">${statusText}</div>
                                    </div>
                                </div>
                                <div>
                                    <img class="slip-photo" src="${userImg}"
                                         alt="User Photo"
                                         onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(res.user_name)}&size=200&background=cccccc&color=333'">
                                </div>
                            </div>

                            <!-- Quiz Breakdown -->
                            <div class="slip-section">Quiz Result Breakdown</div>
                            <table class="slip-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Quiz</th>
                                        <th>Category</th>
                                        <th>Score</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${attemptsRows || '<tr><td colspan="5" class="text-center text-muted">No attempts</td></tr>'}
                                </tbody>
                            </table>

                            <!-- Final Result -->
                            <div class="slip-section">Final Result</div>
                            <table class="slip-table">
                                <thead>
                                    <tr>
                                        <th>Total Score</th>
                                        <th>Percentage</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>${res.total_obtained} / ${res.total_possible}</td>
                                        <td>${res.percentage}%</td>
                                        <td style="color:${passColor}; font-weight:bold;">${res.qualified ? 'PASS' : 'FAIL'}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Note -->
                            <div class="slip-note">
                                <b>Note :</b>
                                <ul>
                                    <li>This is a system generated result.</li>
                                    <li>Contact administrator for any issue.</li>
                                </ul>
                            </div>

                            <!-- Print Button -->
                            <button class="slip-print-btn" onclick="window.print()">Print Slip</button>

                        </div>
                    `);
                },
                error: function () {
                    $('#resultModalBody').html('<p class="text-center text-danger p-3">Failed to load data.</p>');
                }
            });
        });

        // ─── History Modal ─────────────────────────────────────────────
        $(document).on('click', '.btn-view-history', function () {
            var userId = $(this).data('id');
            $('#historyModalBody').html('<div class="text-center py-4"><div class="spinner-border text-info"></div></div>');
            historyModal.show();

            $.ajax({
                url: "{{ url('user/quiz-report/history') }}/" + userId,
                type: "GET",
                success: function (res) {
                    if (!res.status || res.data.length === 0) {
                        $('#historyModalBody').html('<p class="text-center text-muted p-3">No history found.</p>');
                        return;
                    }

                    var today = new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });

                    var rows = '';
                    $.each(res.data, function (i, a) {
                        var badgeClass = getStatusBadgeClass(a.status);
                        rows += `
                        <tr>
                            <td>${a.quiz_name}</td>
                            <td><strong>${a.score} / ${a.total}</strong></td>
                            <td>${a.attempted} / ${a.total}</td>
                            <td>
                                <span class="dt-started">Started: ${a.started_at}</span>
                                <span class="dt-finished">Finished: ${a.finished_at}</span>
                            </td>
                            <td><span class="slip-badge ${badgeClass}">${a.status}</span></td>
                            <td>${a.message}</td>
                        </tr>`;
                    });

                    $('#historyModalLabel').text(res.user_name + ' — Quiz History');
                    $('#historyModalBody').html(`
                        <div class="slip-wrap p-3">

                            <!-- Slip Header -->
                            <div class="slip-header">
                                <div class="slip-logo">Assessment Portal</div>
                                <div class="slip-date">Printed On : ${today}</div>
                            </div>

                            <!-- Title -->
                            <div class="slip-title">Quiz History</div>

                            <!-- Table -->
                            <table class="slip-table dark-head">
                                <thead>
                                    <tr>
                                        <th>Quiz</th>
                                        <th>Score</th>
                                        <th>Attempted</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Message</th>
                                    </tr>
                                </thead>
                                <tbody>${rows}</tbody>
                            </table>

                            <!-- Print Button -->
                            <button class="slip-print-btn" onclick="window.print()">Print Slip</button>

                        </div>
                    `);
                },
                error: function () {
                    $('#historyModalBody').html('<p class="text-center text-danger p-3">Failed to load data.</p>');
                }
            });
        });

        function getStatusBadge(status) {
            if (!status) return 'bg-secondary';
            const s = status.toLowerCase();
            if (s.includes('complete') || s.includes('finish')) return 'bg-success';
            if (s.includes('time out'))   return 'bg-danger';
            if (s.includes('incomplete')) return 'bg-warning';
            return 'bg-secondary';
        }

        function getStatusBadgeClass(status) {
            if (!status) return '';
            const s = status.toLowerCase();
            if (s.includes('time out'))   return 'danger';
            if (s.includes('incomplete')) return 'warning';
            return '';
        }

    });
})(jQuery);
</script>

@endsection