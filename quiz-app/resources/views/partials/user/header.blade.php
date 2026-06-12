<header style="background-color:#e91e77;">
	<div class="logo">TEST YoUR KnowledgE</div>
		<nav class="desktop-nav">
			<a href="#home" class="home_class">Home</a>
			<a href="#about" class="about_class">About</a>
			<a href="#quiz" class="quiz_class">Quiz</a>
			<a href="{{route('winner.announcement')}}">Winners</a>
		
			@if(Auth::check())
				@if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3)
					<a href="{{ route('showLogin') }}" class="btn-contact">My Dashboard</a>
				@else
					<a href="{{ route('logout') }}" class="btn-contact" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
				@endif
			@else
				<a href="{{ route('showLogin') }}" class="btn-contact">Log in</a>
			@endif
		</nav>
	
		<button class="mobile-nav-btn" id="mobileNavBtn"><i class="fas fa-bars"></i></button>
	
	<div class="mobile-nav" id="mobileNav">
		<div class="mobile-nav-header">
			<span class="logo">MyApp</span>
			<button class="mobile-nav-close" id="mobileNavClose"><i class="fas fa-times"></i></button>
		</div>

		<nav class="mobile-nav-menu">
			<a href="#home" class="mobile-nav-link"><i class="fas fa-home"></i> Home</a>
			<a href="#about" class="mobile-nav-link"><i class="fas fa-user"></i> About</a>
			<a href="#regions" class="mobile-nav-link"><i class="fas fa-question-circle"></i> Quiz</a>
			<a href="#winners" class="mobile-nav-link"><i class="fas fa-trophy"></i> Winners</a>
			<a href="#contact" class="mobile-nav-link"><i class="fas fa-envelope"></i> Contact</a>
		</nav>

		<div class="mobile-nav-footer">
			@if(Auth::check())
				@if(Auth::user()->role == 1 || Auth::user()->role == 2)
					<a href="{{ route('showLogin') }}" class="btn-primary">Go to Dashboard</a>
				@else
					<a href="{{ route('logout') }}" class="btn-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout </a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
						@csrf
					</form>
				@endif
			@else
				<a href="{{ route('showLogin') }}" class="btn-primary">Log in</a>
			@endif
		</div>
	</div>	
</header>