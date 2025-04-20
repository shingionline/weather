<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand font-weight-bold" href="/">Weather App</a>
                @auth
                <!-- <div><span class="badge badge-success {{ Auth::user()->account }}" style="font-size:70%;">{{ Auth::user()->account }}</span></div> -->
                @endauth
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            
                                <li class="nav-item">
                                    <a class="btn btn-dark mr-2 mb-2 mb-md-0" href="{{ route('login') }}">Login</a>
                                </li>

                                <li class="nav-item">
                                    <a class="btn btn-primary mb-2 mb-md-0" href="/registration/1">List my property</a>
                                </li>
                            
                        @else
                        <li class="nav-item"><a class="nav-link mr-4 mt-1" href="/dashboard">Dashboard</a></li>
                        
                        <li class="nav-item"><a class="nav-link mr-4 mt-1" href="/properties">Properties</a></li>
<!-- <li class="nav-item"><a class="nav-link mr-4 mt-1" href="https://databanc.co.za/applications">Applications</a></li> -->
                        @if (Auth::user()->account =='Administrator') 
                        <li class="nav-item"><a class="nav-link mr-4 mt-1" href="/accounts">Accounts</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link mr-3 mt-1" href="/profile">Profile</a></li>
                        <li class="nav-item"><a class="nav-link mr-3 mt-1" href="/help">Help</a></li>
                        
    <!-- <messages-top :user="{{ auth()->user() }}" icon="fa-envelope" category="messages" event="NewMessage" update="UpdateMessage"></messages-top>
    <messages-top :user="{{ auth()->user() }}" icon="fa-bell" category="notifications" event="NewNotification" update="UpdateNotification"></messages-top> -->

                        <li class="nav-item dropdown">

                        <avatar :person="{{ auth()->user() }}"></avatar>

                                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="navbarDropdown">
                                
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>