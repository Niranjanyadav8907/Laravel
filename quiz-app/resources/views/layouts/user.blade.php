<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title', 'User Dashboard')</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

	
	@include('loader')
	@include('website_css')
	@include('toaster')
	
	<div class="wrapper">
		@include('partials.user.header')
		@yield('content')
		@include('partials.user.footer')
	</div>

<script>
$(document).ready(function(){
	$(document).on('click' , '.quiz_class' , function(){
		window.location='/quiz-app/public/#quiz';
	});
	$(document).on('click' , '.about_class' , function(){
		window.location='/quiz-app/public/#about';
	});
	$(document).on('click' , '.home_class' , function(){
		window.location='/quiz-app/public/#home';
	});
});
</script>
</body>
</html>