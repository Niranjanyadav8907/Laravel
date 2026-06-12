<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/perfect-scrollbar.min.js" integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://unpkg.com/@popperjs/core@2" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<link rel="stylesheet" href="{{ asset('assets/css/library/material.css') }}">
    </head>
    <body class="mt-0">
		@include('toaster')
		<main class="main-content mt-0 ps">
			<div class="page-header align-items-start min-vh-100" style="background-image: url('{{ asset('assets/images/login-background.webp') }}');">
				<span class="mask bg-gradient-dark opacity-6"></span>
				<div class="container my-auto">
					<div class="row">
						<div class="col-lg-4 col-md-8 col-12 mx-auto">
							<div class="card z-index-0 fadeIn3 fadeInBottom">
								<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
									<div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
										<h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
									</div>
								</div>
								<div class="card-body">
									<form id="login_user_form" class="text-start">
									    @csrf
										<div class="input-group input-group-outline my-3">
											<label class="form-label">Email</label>
											<input type="email" class="form-control" name="email" required="" onfocus="focused(this)" onfocusout="defocused(this)">
										</div>
										<small class="text-danger error-text email_error"></small>
										<div class="input-group input-group-outline mb-3">
											<label class="form-label">Password</label>
											<input type="password" class="form-control" name="password" required="" onfocus="focused(this)" onfocusout="defocused(this)">
										</div>
										<small class="text-danger error-text password_error"></small>
										<div class="form-check form-switch d-flex align-items-center mb-3">
											<input class="form-check-input" type="checkbox" name="rememberMe" id="rememberMe">

											<label class="form-check-label mb-0 ms-2" for="rememberMe">Remember me</label>
										</div>
										<div class="text-center">
											<button type="button" class="btn btn-lg login_user bg-gradient-primary btn-lg w-100 mt-4 mb-0">Sign In</button>
										</div>
										<p class="mt-4 text-sm text-center"> Don't have an account? <a href="{{route('showRegistration')}}" class="text-primary text-gradient font-weight-bold">Sign up</a>
										</p>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		
        <script src="{{ asset('assets/js/library/material.js') }}"></script>
		
		<script>
			$(document).ready(function() {
				$(document).on('click', '.login_user', function () {

					let formData = $('#login_user_form').serialize();

					$('.error-text').text('');

					$.ajax({
						url: "{{ route('ajax.login') }}",
						type: "POST",
						data: formData,
						beforeSend: function () {
							$('.login_user').text('Please wait...').prop('disabled', true);
						},
						success: function (response) {
							if (response.status) {
								showToaster('success', response.message);
								setTimeout(function() {
									window.location.href = response.redirect;
								}, 1000);
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
							$('.login_user').text('Sign In').prop('disabled', false);
						}
					});
				});
				
			});

		</script>
    </body>
</html>