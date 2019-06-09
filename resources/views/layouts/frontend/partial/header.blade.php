<header>
    <div class="container-fluid position-relative no-side-padding">
        <div class="menu-nav-icon" data-nav-menu="#main-menu"><i class="ion-navicon"></i></div>
        <ul class="main-menu visible-on-click" id="main-menu">
            <li><a href="{{ route('home') }}">Home</a></li>
            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
            @else
                @if(Auth::user()->is_admin)
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.article.index') }}">Articles</a></li>
                @else
                    <li><a href="{{ route('visitor.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('visitor.article.index') }}">Articles</a></li>
                @endif
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul><!-- main-menu -->
    </div><!-- conatiner -->
</header>
