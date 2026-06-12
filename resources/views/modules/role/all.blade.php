@extends('layouts.admin')

@section('title', 'Role')
@section('page-title', 'Role')
@section('breadcrumb', 'Role')

@section('content')

<div class="m-1 py-4">
	<div class="row">
		<div class="col-12">
			<div class="card my-4">
				<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
					<div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
						<h6 class="text-white text-capitalize ps-3">Role</h6>
					</div>
				</div>
				
				<div class="card-body px-0 pb-2 m-4">
					
					<div class="table-responsive">
						<i class="fas fa-sync refresh_role cursor-pointer"></i>&nbsp;&nbsp;
						<i class="fas fa-plus create_new_role_modal_button cursor-pointer"></i>
						<table id="roleTable" class="table align-items-center mb-0">
							<thead>
								<tr>	
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Role</th>
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Slug</th>
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Description</th>
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



<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRoleModalLabel">Create New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="add_new_role_form"> 
					@csrf <input type="hidden" name="id" value="">
					<div class="row">
						<div class="col-md-6">
							<div class="input-group input-group-outline my-3">
								<label class="form-label">Role Name</label>
								<input type="text" class="form-control" name="role_name" onfocus="focused(this)" onfocusout="defocused(this)">
							</div>
							<small class="text-danger error-text role_name_error"></small>
						</div>
						<div class="col-md-6" style="display:none;">
							<div class="input-group input-group-outline my-3 is-focused is-filled">
								<label class="form-label">Role Slug</label>
								<input type="text" class="form-control" name="role_slug" placeholder="admin / teacher" onfocus="focused(this)" onfocusout="defocused(this)">
							</div>
							<small class="text-danger error-text role_slug_error"></small>
						</div>
						<div class="col-md-12">
							<div class="input-group input-group-outline my-3">
								<label class="form-label">Description</label>
								<textarea class="form-control" name="description" rows="3" onfocus="focused(this)" onfocusout="defocused(this)"></textarea>
							</div>
							<small class="text-danger error-text description_error"></small>
						</div>
						<div class="col-md-6">
							<div class="input-group input-group-outline my-3 is-focused is-filled">
								<label class="form-label">Status</label>
								<select class="form-control" name="status" onfocus="focused(this)" onfocusout="defocused(this)">
									<option value="" selected>Select Status</option>
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
							<small class="text-danger error-text status_error"></small>
						</div>
						<div class="col-md-6">
							<div class="input-group input-group-outline my-3 is-focused is-filled">
								<label class="form-label">System Role</label>
								<select class="form-control" name="is_system_role" onfocus="focused(this)" onfocusout="defocused(this)">
									<option value="0">No</option>
									<option value="1">Yes</option>
								</select>
							</div>
							<small class="text-danger error-text is_system_role_error"></small>
						</div>
					</div>
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary create_new_role">Save Role</button>
            </div>
        </div>
    </div>
</div>
<script>

	$(document).ready(function() {
	
		$(document).on('click', '.create_new_role', function () {
			showLoader();
			let form = $('.add_new_role_form');
			let formData = form.serialize();

			$('.error-text').text('');

			$.ajax({
				url: "{{ route('add.role.ajax') }}",
				type: "POST",
				data: formData,
				beforeSend: function () {
					$('.create_new_role')
						.text('Please wait...')
						.prop('disabled', true);
				},
				success: function (response) {
					hideLoader();
					if (response.status) {
						showToaster('success', response.message);

						form[0].reset();

						form.find('input, textarea, select').each(function () {
							defocused(this);
						});
						
						rolesData();
					}else{
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
					}else if (xhr.status === 409) {
						showToaster('error', xhr.responseJSON.message);
					}
				},
				complete: function () {
					hideLoader();
					$('.create_new_role').text('Save').prop('disabled', false);
				}
			});
		});
		
		$(document).on('click', '.refresh_role', function () {
			rolesData();
		});
		
		$('.create_new_role_modal_button').on('click', function() {
			$('#createRoleModal').modal('show');
		});
		
		
		rolesData();

		function rolesData() {
			showLoader();
			$.ajax({
				url: "{{ route('role.data') }}",
				type: "GET",
				success: function(response) {
					hideLoader();
					var rows = '';
					var currentUserId = "{{ Auth::id() }}";
					console.log(response);

					$.each(response, function(key, role) {

						var isoDate = role.created_at;
						var dateObj = new Date(isoDate);

						var options = {
							year: 'numeric', month: 'short', day: 'numeric',
							hour: '2-digit', minute: '2-digit',
							hour12: true
						};
						var customDate = dateObj.toLocaleString('en-US', options);

						var role_badge = role.status == 1
							? '<p class="text-xs font-weight-bold mb-0 badge badge-sm bg-gradient-success">Active</p>'
							: '<p class="text-xs font-weight-bold mb-0 badge badge-sm bg-gradient-danger">Inactive</p>';

						var delete_button = '';
						if (role.id != 1 && role.id != 2 && role.id != 3) {
							delete_button = '<i data-id="' + role.id + '" class="fas fa-trash delete_role cursor-pointer"></i>&nbsp;&nbsp;&nbsp;';
						}
						
						var update_status = '';
						if (role.id != 1 && role.id != 2){
							var update_status = `<select class="form-control update_status" data-id="${role.id}" name="update_status" onfocus="focused(this)" onfocusout="defocused(this)">
								<option value="1" ${role.status == 1 ? 'selected' : ''}>Active</option>
								<option value="0" ${role.status == 0 ? 'selected' : ''}>Inactive</option>
							</select>`;
						}

						rows += `
							<tr>
								<td><p class="text-xs font-weight-bold mb-0">${role.role_name ? role.role_name : '-'}</p></td>
								<td><p class="text-xs font-weight-bold mb-0">${role.role_slug ? role.role_slug : '-'}</p></td>
								<td><p class="text-xs font-weight-bold mb-0">${role.description ? role.description : '-'}</p></td>
								<td>
									<div class="input-group input-group-outline is-focused is-filled">
										${role_badge}
										${update_status}
									</div>
								</td>
								<td><p class="text-xs font-weight-bold mb-0">${delete_button}</p></td>
							</tr>
						`;
					});

					$('#roleTable tbody').html(rows);
				},
				error: function(xhr) {
					hideLoader();
					console.log(xhr.responseText);
				}
			});
		}

		
		
		$(document).on('click', '.delete_role', function () {
			var id = $(this).data('id');

			Swal.fire({
				title: 'Are you sure delete role?',
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
						url: "{{ route('role.delete') }}",
						type: "POST",
						data: {
							id: id,
							_token: "{{ csrf_token() }}"
						},
						success: function (response) {
							hideLoader();
							showToaster('success', response.message);
							$('i.delete_role[data-id="'+id+'"]').closest('tr').remove();
						},
						error: function () {
							hideLoader();
							Swal.fire(
								'Error!',
								'Something went wrong during deletion role.',
								'error'
							);
						}
					});
				}
			});
		});
		
		$(document).on('change', '.update_status', function () {
			let status = $(this).val();
			let id = $(this).data('id');

			Swal.fire({
				title: 'Are you sure?',
				text: "You want to change the status of this role!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, change it!',
				cancelButtonText: 'Cancel'
			}).then((result) => {
				if (result.isConfirmed) {
					showLoader(); 

					$.ajax({
						url: "{{ route('role.status.update') }}",
						type: "POST",
						data: {
							status: status,
							id: id,
							_token: "{{ csrf_token() }}"
						},
						success: function (response) {
							hideLoader();
							if (response.status) {
								showToaster('success', response.message);
								rolesData();
							} else {
								showToaster('error', response.message);
							}
						},
						error: function () {
							hideLoader();
							Swal.fire(
								'Error!',
								'Something went wrong during status update.',
								'error'
							);
						}
					});
				} else {
					let prevStatus = $(this).data('prev'); 
					$(this).val(prevStatus);
				}
			});
		});

		$(document).on('focus', '.update_status', function() {
			$(this).data('prev', $(this).val());
		});

		
	});

</script>
@endsection