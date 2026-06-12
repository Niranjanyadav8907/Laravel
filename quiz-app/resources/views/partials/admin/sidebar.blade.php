<style>
.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
    background-color: #e91e77;
    color: #fff;
}

.layout-fixed .main-sidebar {
    bottom: 0;
    float: none;
    left: 0;
    position: fixed;
    top: 0;
    margin: 5px;
    border-radius: 10px;
}

nav.main-header.navbar.navbar-expand.navbar-white.navbar-light {
    margin-right: 80px;
	box-shadow: none;
}


a.nav-link.lightgray_color {
    background-color: lightgray !important;
}


@media (max-width: 991.98px) {
    .sidebar-mini.sidebar-collapse .main-sidebar {
        box-shadow: none !important;
        width: 0px;
    }
}
.input-group.search_module .form-control-sidebar {
    color: white; 
    background-color: #343a40; 
    border-color: #555; 
}

.input-group.search_module .form-control-sidebar::placeholder {
    color: #ccc; 
}

.os-viewport-native-scrollbars-invisible {
    overflow-y: scroll;
    height: 90%;
}
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="https://defenders.topscripts.in/quiz-app/public/" class="brand-link">
        <img src="{{ asset('AdminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">Quiz App</span><br>
		<span class="brand-text font-weight-light m-3">{{ Auth::user()->name ?? 'Admin' }}</span>
    </a>

    <div class="sidebar">

        <!--<div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}"
                     class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name ?? 'Admin' }}</a>
            </div>
        </div>-->

        <div class="form-inline">
            <div class="input-group search_module">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" style="color: white; background-color: #343a40; border-color: #555;">
            </div>
        </div>
		
        <nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

				{{-- Dashboard --}}
				<li class="nav-item">
					<a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
						<i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
					</a>
				</li>
                {{-- Profile--}}
               <li class="nav-item">
					<a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
						<i class="nav-icon fas fa-user-circle"></i>
						<p>My Profile</p>
					</a>
				</li>

                {{-- Quiz Master Management --}}
					<li class="nav-item">
						<a href="{{ route('quizmaster.index') }}" class="nav-link {{ request()->routeIs('quizmaster.index') ? 'active' : '' }}">
							<i class="nav-icon fas fa-user-tie"></i><p>Quiz Master</p>
						</a>
					</li>

				{{-- User Management --}}
				@if(Auth::user()->can('check-access', ['User', 'View']) || Auth::user()->can('check-access', ['User', 'Add']))
					<li class="nav-item has-treeview
						{{ request()->routeIs('users','add.user','user.quiz.report') ? 'menu-open'  : '' }}">

						<a class="nav-link text-dark {{ request()->routeIs('users','add.user','user.quiz.report') ? 'active' : '' }}">
							<i class="fas fa-users nav-icon"></i>
							<p>User<i class="right fas fa-angle-left"></i></p>
						</a>

						<ul class="nav nav-treeview">
							@can('check-access', ['User', 'View'])
								<li class="nav_link_hover_bg">
									<a href="{{ route('users') }}" class="nav-link {{ request()->routeIs('users') ? 'lightgray_color' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="fas fa-user-friends nav-icon"></i>
										<p>All</p>
									</a>
								</li>
							@endcan
							
							@can('check-access', ['User', 'Add'])
								<li class="nav_link_hover_bg">
									<a href="{{ route('add.user') }}" class="nav-link {{ request()->routeIs('add.user') ? 'lightgray_color' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="fas fa-user-plus nav-icon"></i>
										<p>Add</p>
									</a>
								</li>
							@endcan
							
							@can('check-access', ['User', 'View'])
								<li class="nav_link_hover_bg">
									<a href="{{ route('user.quiz.report') }}" 
									   class="nav-link {{ request()->routeIs('user.quiz.report*') ? 'lightgray_color' : '' }}">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="fas fa-chart-bar nav-icon"></i>
										<p>User Quiz Report</p>
									</a>
								</li>
							@endcan
						</ul>
					</li>
				@endif
				
				{{-- Accessibility --}}
				@can('check-access', ['Accessibility', 'View'])
					<li class="nav-item">
						<a href="{{ route('add.accessibility') }}" class="nav-link {{ request()->routeIs('add.accessibility') ? 'active' : '' }}">
							<i class="nav-icon fas fa-universal-access"></i>
							<p>Accessibility</p>
						</a>
					</li>
				@endcan

				{{-- Role Management --}}
				<li class="nav-item">
					<a href="{{ route('all.role') }}" class="nav-link {{ request()->routeIs('all.role') ? 'active' : '' }}">
						<i class="nav-icon fas fa-user-shield"></i><p>Role Management</p>
					</a>
				</li>
				
				{{-- Quiz --}}
				@if(Auth::user()->can('check-access', ['Quiz', 'View']) || Auth::user()->can('check-access', ['Question', 'View']) || Auth::user()->can('check-access', ['QMonitoring', 'View']))
					<li class="nav-item has-treeview
						{{ request()->routeIs('add.quiz','add.question','quiz-attempt-monitoring','add.quiz.category','quiz.schedule') ? 'menu-open' : '' }}">

						<a class="nav-link text-dark
						{{ request()->routeIs('add.quiz','add.question','quiz-attempt-monitoring','add.quiz.category','quiz.schedule') ? 'active' : '' }}">
							<i class="nav-icon fas fa-question-circle"></i>
							<p>Quiz / Question<i class="right fas fa-angle-left"></i>
							</p>
						</a>

						<ul class="nav nav-treeview">
							@can('check-access', ['Quiz', 'View'])
								<li class="nav_link_hover_bg">
									<a href="{{ route('add.quiz') }}" class="nav-link {{ request()->routeIs('add.quiz') ? 'lightgray_color' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="fas fa-clipboard-list nav-icon"></i>
										<p>Quiz</p>
									</a>
								</li>
								<li class="nav_link_hover_bg">
									<a href="{{ route('add.quiz.category') }}" class="nav-link {{ request()->routeIs('add.quiz.category') ? 'lightgray_color' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="fas fa-clipboard-list nav-icon"></i>
										<p>Category</p>
									</a>
								</li>

								<li class="nav_link_hover_bg">
									<a href="{{ route('quiz.schedule') }}" class="nav-link {{ request()->routeIs('quiz.schedule') ? 'lightgray_color' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="fas fa-calendar-alt nav-icon"></i>
										<p>Quiz Schedule</p>
									</a>
								</li>
							@endcan
							@can('check-access', ['Question', 'View'])
								<li class="nav_link_hover_bg">
									<a href="{{ route('add.question') }}" class="nav-link {{ request()->routeIs('add.question') ? 'lightgray_color' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="far fa-circle nav-icon"></i>
										<p>Question</p>
									</a>
								</li>
							@endcan
							@can('check-access', ['QMonitoring', 'View'])
								<li class="nav_link_hover_bg">
									<a href="{{ route('quiz-attempt-monitoring') }}" class="nav-link {{ request()->routeIs('quiz-attempt-monitoring') ? 'lightgray_color' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="fas fa-tasks nav-icon"></i>
										<p>Quiz Monitoring</p>
									</a>
								</li>
							@endcan
								
						</ul>
					</li>
				@endif


               {{-- Leaderboard --}}
				
				@if(Auth::user()->can('check-access', ['TopScorers', 'View']) || Auth::user()->can('check-access', ['Achievement', 'View']))
					<li class="nav-item has-treeview
						{{ request()->routeIs('leaderboard','achievement') ? 'menu-open' : '' }}">

						<a class="nav-link text-dark
						{{ request()->routeIs('leaderboard','achievement') ? 'active' : '' }}">
							<i class="nav-icon fas fa-medal"></i>
							<p>Leaderboard<i class="right fas fa-angle-left"></i></p>
						</a>

						<ul class="nav nav-treeview">
							@can('check-access', ['TopScorers', 'View'])
								<li class="nav_link_hover_bg">
									<a href="{{ route('leaderboard') }}" class="nav-link {{ request()->routeIs('leaderboard') ? 'lightgray_color' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="fas fa-trophy nav-icon"></i>
										<p>Top Scorers</p>
									</a>
								</li>
							@endcan
							@can('check-access', ['Achievement', 'View'])
								<li class="nav_link_hover_bg">
									<a href="{{ route('achievement') }}" class="nav-link {{ request()->routeIs('achievement') ? 'lightgray_color' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="fas fa-award nav-icon"></i>
										<p>Achievement</p>
									</a>
								</li>
							@endcan
						</ul>
					</li>
				@endif
				
                {{-- Subscription / Payment Management --}}
				@if(Auth::user()->can('check-access', ['Plans', 'View']) || Auth::user()->can('check-access', ['Payment', 'View']))
					<li class="nav-item has-treeview
						{{ request()->routeIs('subscription','payment') ? 'menu-open' : '' }}">

						<a class="nav-link text-dark
							{{ request()->routeIs('subscription','payment') ? 'active' : '' }}">
							<i class="nav-icon fas fa-coins"></i>
							<p>Subscriptions<i class="right fas fa-angle-left"></i></p>
						</a>

						<ul class="nav nav-treeview">
							@can('check-access', ['Plans', 'View'])
								<li class="nav_link_hover_bg">
									<a href="{{ route('subscription') }}" class="nav-link {{ request()->routeIs('subscription') ? 'lightgray_color' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="fas fa-list-alt nav-icon"></i>
										<p>Plans</p>
									</a>
								</li>
							@endcan
							@can('check-access', ['Payment', 'View'])
								<li class="nav_link_hover_bg">
									<a href="{{ route('payment') }}" class="nav-link {{ request()->routeIs('payment') ? 'lightgray_color' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="fas fa-credit-card nav-icon"></i>
										<p>Payment</p>
									</a>
								</li>
							@endcan

						</ul>
					</li>
				@endif
				
				<li class="nav-item">
					<a href="{{ route('activity.log') }}" class="nav-link {{ request()->routeIs('activity.log') ? 'active' : '' }}">
						<i class="nav-icon fas fa-cogs"></i>
						<p>Activity</p>
					</a>
				</li>
				
				<li class="nav-item">
					<a href="{{ route('settings') }}" class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}">
						<i class="nav-icon fas fa-cogs"></i>
						<p>Settings</p>
					</a>
				</li>
			
				<li class="nav-item">
					<a href="{{ url('/') }}" class="nav-link">
						<i class="nav-icon fas fa-globe"></i>
						<p>Website</p>
					</a>
				</li>
				
                <!--
                <li class="nav-item"><a href="" class="nav-link"><i class="nav-icon fas fa-folder"></i><p>Categories</p></a></li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Results & Reports<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link"><i class="far fa-circle nav-icon"></i><p>All Results</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Analytics</p></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"><a href="" class="nav-link"><i class="nav-icon fas fa-info-circle"></i><p>About</p></a></li>
                <li class="nav-item"><a href="" class="nav-link"><i class="nav-icon fas fa-envelope"></i><p>Contact</p></a></li> -->

                <li class="nav-item mt-3 cursor-pointer">
                    <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-danger"><i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<script>
$(document).ready(function() {
	$('.nav_link_hover_bg').hover(
		function() {
			$(this).css('background-color', '#d3d3d3');
		},
		function() {
			$(this).css('background-color', ''); 
		}
	);

    $('.form-control-sidebar').on('keyup', function() {
        var query = $(this).val().toLowerCase();

        $('.nav-sidebar > .nav-item').each(function() {
            var $item = $(this);
            var moduleText = $item.find('> a > p').text().toLowerCase();
            var matchFound = false;

            if(moduleText.indexOf(query) !== -1) {
                matchFound = true;
            } else {
                $item.find('.nav-treeview a p').each(function() {
                    if($(this).text().toLowerCase().indexOf(query) !== -1) {
                        matchFound = true;
                        return false; 
                    }
                });
            }

            if(matchFound || query === '') {
                $item.show();
            } else {
                $item.hide();
            }
        });
    });
	
	
});
</script>
