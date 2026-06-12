@extends('layouts.admin')

@section('title', 'Users Update')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

<div class="m-1 py-4">
	<div class="row">
		<div class="col-12">
			<div class="card my-4">
				<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
					<div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
						<h6 class="text-white text-capitalize ps-3">Update</h6>
					</div>
				</div>
				<div class="card-body px-0 pb-2 m-4">
					<form class="update_user_form">
					    @csrf
						<input type="hidden" name="id" value="{{$user->id}}">
						<div class="row">
							<div class="col-md-6">
								<div class="input-group input-group-outline my-3 @if($user->name != '') is-filled @endif">
									<label class="form-label">Name</label>
									<input type="text" class="form-control" value="{{$user->name}}" name="name" onfocus="focused(this)" onfocusout="defocused(this)">
								</div>
								<small class="text-danger error-text name_error"></small>
							</div>
							<div class="col-md-6">
								<div class="input-group input-group-outline my-3 @if($user->email != '') is-filled @endif">
									<label class="form-label">Email</label>
									<input readonly type="email" class="form-control" value="{{$user->email}}" name="email" onfocus="focused(this)" onfocusout="defocused(this)">
								</div>
								<small class="text-danger error-text email_error"></small>
							</div>
							
							<!--<div class="col-md-6">
								<div class="input-group input-group-outline my-3 @if($user->password != '') is-filled @endif">
									<label class="form-label">Password</label>
									<input type="password" class="form-control" value="{{$user->password}}" name="password" onfocus="focused(this)" onfocusout="defocused(this)">
								</div>
								<small class="text-danger error-text password_error"></small>
							</div>
							
							<div class="col-md-6">
								<div class="input-group input-group-outline my-3 @if($user->password != '') is-filled @endif">
									<label class="form-label">New Password</label>
									<input type="password" class="form-control" value="" name="new_password" onfocus="focused(this)" onfocusout="defocused(this)">
								</div>
								<small class="text-danger error-text new_password_error"></small>
							</div> -->
							<div class="col-md-12">
								<div class="form-check form-switch d-flex align-items-center mb-3">
									<input class="form-check-input" type="checkbox" name="is_inactive" id="is_inactive">
									<label class="form-check-label mb-0 ms-2" for="is_inactive"> is inactive?</label>
								</div>
							</div>
							<input class="form-check-input" name="agree_term_condition" type="checkbox" value="" id="flexCheckDefault" checked="" style="display:none;">
							<div class="col-md-12">
								<div class="text-start">
									<button type="button" class="btn btn-lg update_user bg-gradient-primary btn-lg mb-0">Update</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</div>

<script>

	$(document).ready(function() {
		$('.content_header').hide();
		
		$(document).on('click', '.update_user', function () {

			let formData = $('.update_user_form').serialize();

			$('.error-text').text('');

			$.ajax({
				url: "{{ route('ajax.register') }}",
				type: "POST",
				data: formData,
				beforeSend: function () {
					$('.update_user').text('Please wait...').prop('disabled', true);
				},
				success: function (response) {
					
					console.log(response);
					if (response.status) {
						showToaster('success', 'User Update successfully..');
					}
				},
				error: function (xhr) {
					if (xhr.status === 422) {
						let errors = xhr.responseJSON.errors;

						$.each(errors, function (key, value) {
							$('.' + key + '_error').text(value[0]);
						});
					}
				},
				complete: function () {
					$('.update_user').text('Update').prop('disabled', false);
				}
			});
		});
		
	});

</script>
@endsection