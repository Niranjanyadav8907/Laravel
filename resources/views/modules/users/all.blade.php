@extends('layouts.admin')

@section('title', 'Users')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<style>
.red-dot {
    display: inline-block;
    width: 10px;      
    height: 10px;      
    background-color: red;
    border-radius: 50%; 
    position: relative;
}
</style>
<div class="m-1 py-4">
	<div class="row">
		<div class="col-12">
			<div class="card my-4">
				<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
					<div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
						<h6 class="text-white text-capitalize ps-3">User table</h6>
					</div>
				</div>
				<div class="card-body px-0 pb-2">
					
					<div class="table-responsive p-4">
						<i class="fas fa-sync refresh_user cursor-pointer"></i>&nbsp;&nbsp;
						<i class="fas fa-plus add_user_icon cursor-pointer"></i>
						<table id="usersTable" class="table align-items-center mb-0">
							<thead>
								<tr>	
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Author</th>
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Role</th>
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Status</th>
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Created At</th>
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Action</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					
					<!-- <div class="table-responsive p-0">
						<table class="table align-items-center mb-0">
							<thead>
								<tr>
									<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
										Author</th>
									<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
										Function</th>
									<th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
										Status</th>
									<th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
										Employed</th>
									<th class="text-secondary opacity-7"></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<div class="d-flex px-2 py-1">
											<div>
												<img src="https://material-dashboard-laravel.creative-tim.com/assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
											</div>
											<div class="d-flex flex-column justify-content-center">
												<h6 class="mb-0 text-sm">John Michael</h6>
												<p class="text-xs text-secondary mb-0">john@creative-tim.com
												</p>
											</div>
										</div>
									</td>
									<td>
										<p class="text-xs font-weight-bold mb-0">Manager</p>
										<p class="text-xs text-secondary mb-0">Organization</p>
									</td>
									<td class="align-middle text-center text-sm">
										<span class="badge badge-sm bg-gradient-success">Online</span>
									</td>
									<td class="align-middle text-center">
										<span class="text-secondary text-xs font-weight-bold">23/04/18</span>
									</td>
									<td class="align-middle">
										<a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
											Edit
										</a>
									</td>
								</tr>
								<tr>
									<td>
										<div class="d-flex px-2 py-1">
											<div>
												<img src="https://material-dashboard-laravel.creative-tim.com/assets/img/team-3.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user2">
											</div>
											<div class="d-flex flex-column justify-content-center">
												<h6 class="mb-0 text-sm">Alexa Liras</h6>
												<p class="text-xs text-secondary mb-0">
													alexa@creative-tim.com</p>
											</div>
										</div>
									</td>
									<td>
										<p class="text-xs font-weight-bold mb-0">Programator</p>
										<p class="text-xs text-secondary mb-0">Developer</p>
									</td>
									<td class="align-middle text-center text-sm">
										<span class="badge badge-sm bg-gradient-secondary">Offline</span>
									</td>
									<td class="align-middle text-center">
										<span class="text-secondary text-xs font-weight-bold">11/01/19</span>
									</td>
									<td class="align-middle">
										<a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
											Edit
										</a>
									</td>
								</tr>
								<tr>
									<td>
										<div class="d-flex px-2 py-1">
											<div>
												<img src="https://material-dashboard-laravel.creative-tim.com/assets/img/team-4.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user3">
											</div>
											<div class="d-flex flex-column justify-content-center">
												<h6 class="mb-0 text-sm">Laurent Perrier</h6>
												<p class="text-xs text-secondary mb-0">
													laurent@creative-tim.com</p>
											</div>
										</div>
									</td>
									<td>
										<p class="text-xs font-weight-bold mb-0">Executive</p>
										<p class="text-xs text-secondary mb-0">Projects</p>
									</td>
									<td class="align-middle text-center text-sm">
										<span class="badge badge-sm bg-gradient-success">Online</span>
									</td>
									<td class="align-middle text-center">
										<span class="text-secondary text-xs font-weight-bold">19/09/17</span>
									</td>
									<td class="align-middle">
										<a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
											Edit
										</a>
									</td>
								</tr>
								<tr>
									<td>
										<div class="d-flex px-2 py-1">
											<div>
												<img src="https://material-dashboard-laravel.creative-tim.com/assets/img/team-3.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user4">
											</div>
											<div class="d-flex flex-column justify-content-center">
												<h6 class="mb-0 text-sm">Michael Levi</h6>
												<p class="text-xs text-secondary mb-0">
													michael@creative-tim.com</p>
											</div>
										</div>
									</td>
									<td>
										<p class="text-xs font-weight-bold mb-0">Programator</p>
										<p class="text-xs text-secondary mb-0">Developer</p>
									</td>
									<td class="align-middle text-center text-sm">
										<span class="badge badge-sm bg-gradient-success">Online</span>
									</td>
									<td class="align-middle text-center">
										<span class="text-secondary text-xs font-weight-bold">24/12/08</span>
									</td>
									<td class="align-middle">
										<a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
											Edit
										</a>
									</td>
								</tr>
								<tr>
									<td>
										<div class="d-flex px-2 py-1">
											<div>
												<img src="https://material-dashboard-laravel.creative-tim.com/assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user5">
											</div>
											<div class="d-flex flex-column justify-content-center">
												<h6 class="mb-0 text-sm">Richard Gran</h6>
												<p class="text-xs text-secondary mb-0">
													richard@creative-tim.com</p>
											</div>
										</div>
									</td>
									<td>
										<p class="text-xs font-weight-bold mb-0">Manager</p>
										<p class="text-xs text-secondary mb-0">Executive</p>
									</td>
									<td class="align-middle text-center text-sm">
										<span class="badge badge-sm bg-gradient-secondary">Offline</span>
									</td>
									<td class="align-middle text-center">
										<span class="text-secondary text-xs font-weight-bold">04/10/21</span>
									</td>
									<td class="align-middle">
										<a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
											Edit
										</a>
									</td>
								</tr>
								<tr>
									<td>
										<div class="d-flex px-2 py-1">
											<div>
												<img src="https://material-dashboard-laravel.creative-tim.com/assets/img/team-4.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user6">
											</div>
											<div class="d-flex flex-column justify-content-center">
												<h6 class="mb-0 text-sm">Miriam Eric</h6>
												<p class="text-xs text-secondary mb-0">
													miriam@creative-tim.com</p>
											</div>
										</div>
									</td>
									<td>
										<p class="text-xs font-weight-bold mb-0">Programator</p>
										<p class="text-xs text-secondary mb-0">Developer</p>
									</td>
									<td class="align-middle text-center text-sm">
										<span class="badge badge-sm bg-gradient-secondary">Offline</span>
									</td>
									<td class="align-middle text-center">
										<span class="text-secondary text-xs font-weight-bold">14/09/20</span>
									</td>
									<td class="align-middle">
										<a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
											Edit
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div> -->
				</div>
			</div>
		</div>
	</div>
    
	<!--<div class="row">
		<div class="col-12">
			<div class="card my-4">
				<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
					<div class="bg-gradient-dark shadow-primary dark-radius-lg pt-4 pb-3">
						<h6 class="text-white text-capitalize ps-3">Projects table</h6>
					</div>
				</div>
				<div class="card-body px-0 pb-2">
					<div class="table-responsive p-0">
						
						<table class="table align-items-center justify-content-center mb-0">
							<thead>
								<tr>
									<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
										Project</th>
									<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
										Budget</th>
									<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
										Status</th>
									<th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
										Completion</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<div class="d-flex px-2">
											<div>
												<img src="https://material-dashboard-laravel.creative-tim.com/assets/img/small-logos/logo-asana.svg" class="avatar avatar-sm rounded-circle me-2" alt="spotify">
											</div>
											<div class="my-auto">
												<h6 class="mb-0 text-sm">Asana</h6>
											</div>
										</div>
									</td>
									<td>
										<p class="text-sm font-weight-bold mb-0">$2,500</p>
									</td>
									<td>
										<span class="text-xs font-weight-bold">working</span>
									</td>
									<td class="align-middle text-center">
										<div class="d-flex align-items-center justify-content-center">
											<span class="me-2 text-xs font-weight-bold">60%</span>
											<div>
												<div class="progress">
													<div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
												</div>
											</div>
										</div>
									</td>
									<td class="align-middle">
										<button class="btn btn-link text-secondary mb-0">
											<i class="fa fa-ellipsis-v text-xs"></i>
										</button>
									</td>
								</tr>
								<tr>
									<td>
										<div class="d-flex px-2">
											<div>
												<img src="https://material-dashboard-laravel.creative-tim.com/assets/img/small-logos/github.svg" class="avatar avatar-sm rounded-circle me-2" alt="invision">
											</div>
											<div class="my-auto">
												<h6 class="mb-0 text-sm">Github</h6>
											</div>
										</div>
									</td>
									<td>
										<p class="text-sm font-weight-bold mb-0">$5,000</p>
									</td>
									<td>
										<span class="text-xs font-weight-bold">done</span>
									</td>
									<td class="align-middle text-center">
										<div class="d-flex align-items-center justify-content-center">
											<span class="me-2 text-xs font-weight-bold">100%</span>
											<div>
												<div class="progress">
													<div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
												</div>
											</div>
										</div>
									</td>
									<td class="align-middle">
										<button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-ellipsis-v text-xs"></i>
										</button>
									</td>
								</tr>
								<tr>
									<td>
										<div class="d-flex px-2">
											<div>
												<img src="https://material-dashboard-laravel.creative-tim.com/assets/img/small-logos/logo-atlassian.svg" class="avatar avatar-sm rounded-circle me-2" alt="jira">
											</div>
											<div class="my-auto">
												<h6 class="mb-0 text-sm">Atlassian</h6>
											</div>
										</div>
									</td>
									<td>
										<p class="text-sm font-weight-bold mb-0">$3,400</p>
									</td>
									<td>
										<span class="text-xs font-weight-bold">canceled</span>
									</td>
									<td class="align-middle text-center">
										<div class="d-flex align-items-center justify-content-center">
											<span class="me-2 text-xs font-weight-bold">30%</span>
											<div>
												<div class="progress">
													<div class="progress-bar bg-gradient-danger" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="30" style="width: 30%;"></div>
												</div>
											</div>
										</div>
									</td>
									<td class="align-middle">
										<button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-ellipsis-v text-xs"></i>
										</button>
									</td>
								</tr>
								<tr>
									<td>
										<div class="d-flex px-2">
											<div>
												<img src="https://material-dashboard-laravel.creative-tim.com/assets/img/small-logos/bootstrap.svg" class="avatar avatar-sm rounded-circle me-2" alt="webdev">
											</div>
											<div class="my-auto">
												<h6 class="mb-0 text-sm">Bootstrap</h6>
											</div>
										</div>
									</td>
									<td>
										<p class="text-sm font-weight-bold mb-0">$14,000</p>
									</td>
									<td>
										<span class="text-xs font-weight-bold">working</span>
									</td>
									<td class="align-middle text-center">
										<div class="d-flex align-items-center justify-content-center">
											<span class="me-2 text-xs font-weight-bold">80%</span>
											<div>
												<div class="progress">
													<div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="80" style="width: 80%;"></div>
												</div>
											</div>
										</div>
									</td>
									<td class="align-middle">
										<button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-ellipsis-v text-xs"></i>
										</button>
									</td>
								</tr>
								<tr>
									<td>
										<div class="d-flex px-2">
											<div>
												<img src="https://material-dashboard-laravel.creative-tim.com/assets/img/small-logos/logo-slack.svg" class="avatar avatar-sm rounded-circle me-2" alt="slack">
											</div>
											<div class="my-auto">
												<h6 class="mb-0 text-sm">Slack</h6>
											</div>
										</div>
									</td>
									<td>
										<p class="text-sm font-weight-bold mb-0">$1,000</p>
									</td>
									<td>
										<span class="text-xs font-weight-bold">canceled</span>
									</td>
									<td class="align-middle text-center">
										<div class="d-flex align-items-center justify-content-center">
											<span class="me-2 text-xs font-weight-bold">0%</span>
											<div>
												<div class="progress">
													<div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0" style="width: 0%;"></div>
												</div>
											</div>
										</div>
									</td>
									<td class="align-middle">
										<button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-ellipsis-v text-xs"></i>
										</button>
									</td>
								</tr>
								<tr>
									<td>
										<div class="d-flex px-2">
											<div>
												<img src="https://material-dashboard-laravel.creative-tim.com/assets/img/small-logos/devto.svg" class="avatar avatar-sm rounded-circle me-2" alt="xd">
											</div>
											<div class="my-auto">
												<h6 class="mb-0 text-sm">Devto</h6>
											</div>
										</div>
									</td>
									<td>
										<p class="text-sm font-weight-bold mb-0">$2,300</p>
									</td>
									<td>
										<span class="text-xs font-weight-bold">done</span>
									</td>
									<td class="align-middle text-center">
										<div class="d-flex align-items-center justify-content-center">
											<span class="me-2 text-xs font-weight-bold">100%</span>
											<div>
												<div class="progress">
													<div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
												</div>
											</div>
										</div>
									</td>
									<td class="align-middle">
										<button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-ellipsis-v text-xs"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>-->
   
</div>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


<script>
(function($) {
	$(document).ready(function() {
		$('.content_header').hide();

		var usersTable = $('#usersTable').DataTable({
			responsive: true,
			columns: [
				{ orderable: true },
				{ orderable: true },
				{ orderable: true },
				{ orderable: true },
				{ orderable: false, searchable: false }
			],
			pageLength: 10,
			order: [[0, 'asc']]
		});
		
		$(document).on('click' , '.refresh_user' , function(){
			usersData();
		});
		
		$(document).on('click', '.add_user_icon', function () {
			showLoader();
			window.location = 'user/add';
			hideLoader();
		});
		
		usersData();

		function usersData(){
			showLoader();
			$.ajax({
				url: "{{ route('users.data') }}",
				type: "GET",
				success: function(response){
					hideLoader();
					var rows = '';
					var currentUserId = "{{ Auth::id() }}"; 
					
					$.each(response, function(key, user){
						
						var isoDate = user.created_at;
						var dateObj = new Date(isoDate);
						
						var options = { 
							year: 'numeric', month: 'short', day: 'numeric', 
							hour: '2-digit', minute: '2-digit',
							hour12: true
						};
						var customDate = dateObj.toLocaleString('en-US', options);
						
						var user_status = '';
						if(user.status == 'inactive'){
							user_status = '<span class="red-dot"></span>';
						}

						var role_badge = 'badge badge-sm bg-gradient-success';
						if(user.role == 'admin'){
							role_badge = 'badge badge-sm bg-gradient-dark';
						}else if(user.role == 'user'){
							role_badge = 'badge badge-sm bg-gradient-warning';
						}

						var editUrl = "{{ url('user') }}/" + user.id + "/edit";

						var delete_button = '';
						if(user.role != 'admin' && user.id != currentUserId && user.id != 1){
							delete_button = '<i data-id="'+user.id+'" class="fas fa-trash delete_user cursor-pointer"></i>&nbsp;&nbsp;&nbsp;';
						}
						
						rows += '<tr>'+
							'<td>'+
								'<div class="d-flex px-2 py-1">'+
									'<div>'+
										'<img src="'+(user.image ? "{{ asset('assets/images/profile_images/') }}/"+user.image : "https://ui-avatars.com/api/?name="+encodeURIComponent(user.name)+"&size=200&background=random")+'" class="avatar avatar-sm me-3 border-radius-lg" alt="'+user.name+'">'+
									'</div>'+
									'<div class="d-flex flex-column justify-content-center">'+
										'<a href="'+editUrl+'"><h6 class="mb-0 text-sm">'+user.name+' '+user_status+'</h6></a>'+
										'<p class="text-xs text-secondary mb-0">'+user.email+'</p>'+
									'</div>'+
								'</div>'+
							'</td>'+
							'<td><p class="text-xs font-weight-bold mb-0 '+role_badge+'">'+user.role+'</p></td>'+
							'<td><p class="text-xs font-weight-bold mb-0">'+user.status+'</p></td>'+
							'<td><p class="text-xs font-weight-bold mb-0">'+customDate+'</p></td>'+
							'<td><p class="text-xs font-weight-bold mb-0">'+delete_button+'<a href="'+editUrl+'"><i class="fas fa-edit edit_user cursor-pointer"></i></a></p></td>'+
						'</tr>';
					});

					usersTable.destroy();
					$('#usersTable tbody').html(rows);
					usersTable = $('#usersTable').DataTable({
						responsive: true,
						columns: [
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
				error: function(xhr){
					hideLoader();
					console.log(xhr.responseText);
				}
			});
		}

		$(document).on('click', '.delete_user', function () {
			var id = $(this).data('id');

			Swal.fire({
				title: 'Are you sure delete user?',
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
						url: "{{ route('users.delete') }}",
						type: "POST",
						data: {
							id: id,
							_token: "{{ csrf_token() }}"
						},
						success: function (response) {
							hideLoader();
							showToaster('success', response.message);
							usersData(); 
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

	});
})(jQuery);
</script>


@endsection
