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

    <a href="" class="brand-link">
        <img src="{{ asset('AdminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">Quiz App</span><br>
		<span class="brand-text font-weight-light m-3">{{ Auth::user()->name ?? 'User' }}</span>
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
                        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                        </a>
                    </li>
					
                    {{-- Profile--}}
                    <li class="nav-item">
                        <a href="{{ route('user.profile') }}" class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-circle"></i>
                            <p>My Profile</p>
                        </a>
                    </li>
                    {{-- Quiz History --}}
                    <li class="nav-item">
                        <a href="{{ route('quiz.history') }}" class="nav-link {{ request()->routeIs('quiz.history') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Quiz History</p>
                        </a>
                    </li>

                    {{-- My Result --}}
                    <li class="nav-item">
                        <a href="{{ route('user.result') }}" class="nav-link {{ request()->routeIs('user.result') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-poll"></i>
                            <p>My Result</p>
                        </a>
                    </li>

                    {{-- Achievements --}}
                    <li class="nav-item">
                        <a href="{{ route('user.achievements') }}" class="nav-link {{ request()->routeIs('user.achievements') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-trophy"></i>
                            <p>Achievements</p>
                        </a>
                    </li>
					<li class="nav-item">
						<a href="{{ url('/') }}" class="nav-link">
							<i class="nav-icon fas fa-globe"></i>
							<p>Website</p>
						</a>
					</li>
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
