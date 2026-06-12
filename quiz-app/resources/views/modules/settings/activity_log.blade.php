@extends('layouts.admin')

@section('title', 'Activity Logs')
@section('page-title', 'Activity Logs')
@section('breadcrumb', 'Activity Logs') 

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">

                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Activity Log List</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2 m-4">
                    <div class="table-responsive">

                        <i class="fas fa-sync refresh_activity_log cursor-pointer"></i>

                        <table class="table activityLogTable" style="width:100%;">
                            <thead>
							<tr>
								<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">#Id</th>
								<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">user_name</th>
								<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">action</th>
								<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">module</th>
								<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">description</th>
								<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">method</th>
								<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">status_code</th>
								<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">ip_address</th>
								<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">created_at</th>
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

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
(function($) {
    $(document).ready(function() {

        activityLogData();

        $('.refresh_activity_log').on('click', function(){
            activityLogData();
        });

        function activityLogData() {
			showLoader();

			$.get("{{ route('activity.logs.data') }}").done(function (response) {
				let rows = '';
				if (response.status && response.logs.length > 0) {
					response.logs.forEach(log => {
						rows += `
						<tr>
							<td>${log.id ?? ''}</td>
							<td>${log.user_name ?? ''}</td>
							<td>${log.action ?? ''}</td>
							<td>${log.module ?? ''}</td>
							<td>${log.description ?? ''}</td>
							<td>${log.method ?? ''}</td>
							<td>${log.status_code ?? ''}</td>
							<td>${log.ip_address ?? ''}</td>
							<td>${log.created_at ?? ''}</td>
						</tr>`;
					});
				} else {
					rows = `<tr><td colspan="9" class="text-center">No activity logs found</td></tr>`;
				}

				if ($.fn.DataTable.isDataTable('.activityLogTable')) {
					$('.activityLogTable').DataTable().destroy();
				}

				$('.activityLogTable tbody').html(rows);
				$('.activityLogTable').DataTable({
					responsive: true,
					pageLength: 10,
					order: [[0, 'desc']]
				});
				hideLoader();
			})
			.fail(function (err) {
				hideLoader();
				console.error('Activity log fetch error', err);
			});
		}

    });
})(jQuery);
</script>

@endsection