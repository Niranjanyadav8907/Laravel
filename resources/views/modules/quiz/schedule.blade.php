@extends('layouts.admin')

@section('title', 'Quiz Schedule')
@section('page-title', 'Quiz Schedule')
@section('breadcrumb', 'Quiz Schedule') 

@section('content')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Quiz Schedule List</h6>
                    </div>
                </div>
                
                <div class="card-body px-0 pb-2 m-4">
                    <div class="table-responsive">
                        <i class="fas fa-sync refresh_schedule cursor-pointer"></i>
                        <table class="table scheduleTable align-items-center mb-0" style="width:100%;">
                            <thead>
                                <tr>    
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Quiz Title</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Date</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Schedule</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Quiz Control</th>
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
<div class="modal fade" id="quizImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title mb-0">Quiz Image</h5>
                <button type="button" class="btn-close bg-dark ms-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="quiz_image_container text-center m-1">
                <img src="" class="img-fluid rounded quiz_image_src" alt="Quiz Image" style="width: 100%;height: 400px;">
            </div>
        </div>
    </div>
</div>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
(function($) {
    $(document).ready(function() {
        $('.content_header').hide();
        var scheduleTable = $('.scheduleTable').DataTable({
            responsive: true,
            columns: [
                { orderable: true },
                { orderable: true },
                { orderable: false, searchable: false },
                { orderable: false, searchable: false }
            ],
            pageLength: 10,
            order: [[0, 'asc']]
        });

        loadScheduleData();

        $(document).on('click', '.quizimage', function () {
            var imgSrc = $(this).attr('src');
            $('.quiz_image_src').attr('src', imgSrc);
            new bootstrap.Modal(document.getElementById('quizImageModal')).show();
        });

        $(document).on('click', '.refresh_schedule', function () {
            loadScheduleData();
        });

        $(document).on('click', '.date-picker-trigger', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            let $this = $(this);
            let quizId = $this.data('id');
            let currentDate = $this.data('date');

            if ($this.data('daterangepicker')) {
                $this.data('daterangepicker').remove();
            }
            
            $this.daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
                timePickerSeconds: false,
                autoUpdateInput: false,
                startDate: currentDate ? moment(currentDate) : moment(),
                minDate: moment(),
                locale: {
                    format: 'YYYY-MM-DD HH:mm',
                    cancelLabel: 'Clear'
                },
                drops: 'auto',
                opens: 'left'
            }, function(start, end, label) {
                let selectedDate = start.format('YYYY-MM-DD HH:mm:ss');
                updateQuizPlanner(quizId, selectedDate);
            });
            
            $this.on('cancel.daterangepicker', function(ev, picker) {
                updateQuizPlanner(quizId, '');
            });
            
            $this.data('daterangepicker').show();
        });

        $(document).on('change', '.update_schedule_type', function () {
            let scheduleType = $(this).val();
            let id = $(this).data('id');
            let $this = $(this);

            if (!scheduleType) {
                showToaster('error', 'Please select a schedule type');
                $this.val($this.data('prev'));
                return;
            }

            Swal.fire({
                title: 'Update Schedule Type?',
                text: "Set schedule as " + scheduleType,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();
                    $.ajax({
                        url: "{{ route('quiz.schedule.type.update') }}", 
                        type: "POST",
                        data: {
                            id: id,
                            schedule: scheduleType,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            hideLoader();
                            if (response.status) {
                                showToaster('success', response.message);
                                loadScheduleData();
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

        $(document).on('change', '.update_quiz_control', function () {
            let control = $(this).val();
            let id = $(this).data('id');
            let $this = $(this);

            let actionText = control ? control : 'activate';

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to " + actionText + " this quiz!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();
                    $.ajax({
                        url: "{{ route('quiz.control.update') }}", 
                        type: "POST",
                        data: {
                            id: id,
                            quiz_controls: control,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            hideLoader();
                            if (response.status) {
                                showToaster('success', response.message);
                                loadScheduleData();
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

        $(document).on('focus', '.update_schedule_type, .update_quiz_control', function () {
            $(this).data('prev', $(this).val());
        });

        function updateQuizPlanner(quizId, date) {
            showLoader();
            $.ajax({
                url: "{{ route('quiz.planner.update') }}",
                type: "POST",
                data: {
                    id: quizId,
                    quiz_planner: date,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    hideLoader();
                    if (response.status) {
                        showToaster('success', response.message);
                        loadScheduleData();
                    } else {
                        showToaster('error', response.message);
                    }
                },
                error: function (xhr) {
                    hideLoader();
                    console.error('Error:', xhr);
                    Swal.fire('Error!', 'Failed to update date.', 'error');
                }
            });
        }

        function loadScheduleData() {
            showLoader();
            $.ajax({
                url: "{{ route('quiz.schedule.data') }}",
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    let rows = [];

                    if (response && response.length > 0) {
                        response.forEach(quiz => {
                            const description = quiz.quiz_description ? quiz.quiz_description.substring(0, 30) + '...' : '-';
                            
                            var img_url = "{{ asset('assets/images/quiz_images/quiz_default_image.webp') }}";
                            if(quiz.quiz_image){
                                img_url = "{{ asset('assets/images/quiz_images') }}" + "/" + quiz.quiz_image;
                            }
                            let plannerDate = quiz.quiz_planner ? moment(quiz.quiz_planner).format('DD MMM YYYY, hh:mm A') : '';

                            rows.push([
                                // Column 1 - Quiz Title
                                `<div class="d-flex align-items-center">
                                    <img src="${escapeHtml(img_url)}" class="me-3 rounded cursor-pointer quizimage" width="50" height="50" alt="Quiz Image">
                                    <div>
                                        <h6 class="mb-0 text-sm">${escapeHtml(quiz.quiz_title)}</h6>
                                        <p class="text-xs text-secondary mb-0">${escapeHtml(description)}</p>
                                    </div>
                                </div>`,

                                // Column 2 - Date Picker
                                `<span class="date-input-cell date-picker-trigger" 
                                    data-id="${quiz.id}"
                                    data-date="${quiz.quiz_planner || ''}"
                                    title="Click to select date">
                                    <i class="fas fa-calendar-alt text-info me-2"></i>
                                    <span class="date-display ${plannerDate ? '' : 'empty-date'}">
                                        ${plannerDate ? plannerDate : 'Click to set date'}
                                    </span>
                                </span>`,

                                // Column 3 - Schedule Type
                                `<div class="input-group input-group-outline is-filled">
                                    ${scheduleUI(quiz.schedule, quiz.id)}
                                </div>`,

                                // Column 4 - Quiz Control
                                `<div class="input-group input-group-outline is-filled">
                                    ${quizControlUI(quiz.quiz_controls, quiz.id)}
                                </div>`
                            ]);
                        });
                    }
                    
                    scheduleTable.destroy();
                    $('.scheduleTable tbody').html('');

                    if (rows.length > 0) {
                        scheduleTable = $('.scheduleTable').DataTable({
                            responsive: true,
                            data: rows,
                            columns: [
                                { orderable: true },
                                { orderable: true },
                                { orderable: false, searchable: false },
                                { orderable: false, searchable: false }
                            ],
                            pageLength: 10,
                            order: [[0, 'asc']]
                        });
                    } else {
                        scheduleTable = $('.scheduleTable').DataTable({
                            responsive: true,
                            columns: [
                                { orderable: true },
                                { orderable: true },
                                { orderable: false, searchable: false },
                                { orderable: false, searchable: false }
                            ],
                            pageLength: 10,
                            language: {
                                emptyTable: 'No active quizzes found'
                            }
                        });
                    }

                    hideLoader();
                },
                error: function(xhr) {
                    hideLoader();
                    console.error('Schedule fetch error:', xhr);
                    showToaster('error', 'Failed to load quiz data');
                }
            });
        }

        function scheduleUI(schedule, id) {
            const colors = {
                'one-time': 'info',
                'recurring': 'warning',
                '': 'secondary'
            };

            let options = ['', 'one-time', 'recurring'].map(s => 
                `<option value="${s}" ${s === schedule ? 'selected' : ''}>${s ? s : 'Select Type'}</option>`
            ).join('');

            let color = colors[schedule] || 'secondary';

            return `
                <select class="form-control update_schedule_type border-${color}" 
                        data-id="${id}" 
                        style="border-top: 2px solid var(--bs-${color});">
                    ${options}
                </select>
            `;
        }

        function quizControlUI(control, id) {
            const colors = {
                'pause': 'warning',
                'reschedule': 'info',
                'cancel': 'danger',
                '': 'success'
            };

            let options = ['', 'pause', 'reschedule', 'cancel'].map(c => 
                `<option value="${c}" ${c === control ? 'selected' : ''}>${c ? c : 'Active'}</option>`
            ).join('');

            let color = colors[control] || 'success';

            return `
                <select class="form-control update_quiz_control border-${color}" 
                        data-id="${id}" 
                        style="border-top: 2px solid var(--bs-${color});">
                    ${options}
                </select>
            `;
        }

        function escapeHtml(text) {
            if (!text) return '';
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }
    });
})(jQuery);
</script>

<style>
.date-input-cell {
    cursor: pointer;
    padding: 8px 12px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    background: #f8f9fa;
    transition: all 0.3s;
    display: inline-block;
    min-width: 200px;
    white-space: nowrap;
}
.date-input-cell:hover {
    background: #e9ecef;
    border-color: #ced4da;
}
.date-display {
    font-size: 13px;
    color: #495057;
    display: inline-block;
    vertical-align: middle;
}
.empty-date {
    color: #adb5bd;
    font-style: italic;
}
.date-input-cell i {
    vertical-align: middle;
}

.scheduleTable td {
    vertical-align: middle !important;
}

.scheduleTable tbody tr {
    transition: none;
}
</style>

@endsection