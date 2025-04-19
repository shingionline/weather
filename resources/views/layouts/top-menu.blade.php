<nav class="navbar py-md-2 navbar-expand-md navbar-light sticky-top top-menu-bg">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="/">Weather App</a>

        <div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav ml-auto">

                @guest
                <li class="nav-item"><a class="navigation-link item logged mr-2" href="/">Login</a></li>
                <li class="nav-item"><a class="navigation-link item logged mr-2" href="/register">Register</a></li>

                @else
                <li class="nav-item"><a class="navigation-link item logged" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Logout</a></li>

                @endguest

                <form id="logout-form" 
                action="{{ route('logout') }}" 
                method="POST" 
                class="d-none">@csrf</form>

            </ul>
        </div>
    </div>
</nav>