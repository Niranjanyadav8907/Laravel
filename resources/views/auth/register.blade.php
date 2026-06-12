
<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/perfect-scrollbar.min.js" integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://unpkg.com/@popperjs/core@2" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<link rel="stylesheet" href="{{ asset('assets/css/library/material.css') }}">
    </head>
    <body class="mt-0" style="background-color: aliceblue;">
		@include('toaster')
		<section>
			<div class="page-header min-vh-100">
				<div class="container">
					<div class="row">
						<div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
							<div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('{{ asset('assets/images/login-background.webp') }}'); background-size: cover;"></div>
						</div>
						<div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
							<div class="card card-plain">
								<div class="card-header bg-primary">
									<h4 class="font-weight-bolder">Sign Up</h4>
									<p class="mb-0 text-dark">Enter your email and password to register</p>
								</div>
								<div class="card-body bg-white">
									<form class="register_new_user_form">
										@csrf
										<input type="hidden" name="id" value="">
										<div class="input-group input-group-outline mb-3 input_group_outline">
											<label class="form-label">Name</label>
											<input type="text" class="form-control" name="name" required="" onfocus="focused(this)" onfocusout="defocused(this)">
										</div>
										<small class="text-danger error-text name_error"></small>
										<div class="input-group input-group-outline mb-3 input_group_outline">
											<label class="form-label">Email</label>
											<input type="email" class="form-control" name="email" required="" onfocus="focused(this)" onfocusout="defocused(this)">
										</div>
										<small class="text-danger error-text email_error"></small>
										<div class="input-group input-group-outline mb-3 input_group_outline">
											<label class="form-label">Password</label>
											<input type="password" class="form-control" name="password" required="" onfocus="focused(this)" onfocusout="defocused(this)">
										</div>
										<small class="text-danger error-text password_error"></small>
										<div class="form-check form-check-info text-start ps-0">
											<input class="form-check-input" name="agree_term_condition" type="checkbox" value="" id="flexCheckDefault" checked="">
											<label class="form-check-label" for="flexCheckDefault"> I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
											</label>
										</div>
										<div class="text-center">
											<button type="button" class="btn btn-lg create_new_user bg-gradient-primary btn-lg w-100 mt-4 mb-0">Sign Up</button>
										</div>
									</form>
								</div>
								<div class="card-footer text-center pt-0 px-lg-2 px-1">
									<p class="mb-2 text-sm mx-auto"> Already have an account? <a href="{{route('showLogin')}}" class="text-primary text-gradient font-weight-bold">Sign In</a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		
        <script src="{{ asset('assets/js/library/material.js') }}"></script>
		
		<script>
			$(document).ready(function() {
				$(document).on('click', '.create_new_user', function () {

					let formData = $('.register_new_user_form').serialize();

					$('.error-text').text('');

					$.ajax({
						url: "{{ route('ajax.register') }}",
						type: "POST",
						data: formData,
						beforeSend: function () {
							$('.create_new_user').text('Please wait...').prop('disabled', true);
						},
						success: function (response) {
							if (response.status) {
								showToaster('success', response.message);
								$('.register_new_user_form')[0].reset();
								$('.register_new_user_form').find('input').each(function () {defocused(this); });
								
								setTimeout(function() {
									window.location = "login";
								}, 2000);
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
							$('.create_new_user').text('Sign Up').prop('disabled', false);
						}
					});
				});
				
			});

		</script>
    </body>
</html>