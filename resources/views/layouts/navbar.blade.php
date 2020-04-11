<header class="shadow">
    {{-- Desktop Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="/">Eyesh<span class="logo-globe">🌍</span>t</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#openXsNav"
            aria-controls="openXsNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-center" id="openXsNav">

            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/feed">Feed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/categories">Categories</a>
                </li>
            </ul>
            
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-flex justify-content-center">
                    <form class="form-search" action="/search" method="get">
                        <input type="text" class="search-input" name="q" placeholder="Search for Eyeshot or Location">
                        <span class="search-icon">
                            <button class="button-icon">🔍</button>
                        </span>
                    </form>
                </li>

                @auth
                <li class="nav-item" id="app-install">
                @if ( Request::is('/') )
                    <button class="button-es btn mt-1 pwa-install"><i class="fas fa-plus"></i> Get the App</button>
                @else
                    <a href="/" class="button-es btn mt-1">Explore Now</a>
                @endif
                </li>
                @endauth
                
                <li class="nav-item eyeshot-user">
                    @auth
                    {{-- <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ ucfirst(Auth::user()->name) }} <i class="fas fa-chevron-down"></i>
                    </a> --}}

                    <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img class="eyeshot-user" src="{{ str_replace(["https://", "http://"], "https://", Auth::user()->avatar ) }}" alt="{{ Auth::user()->name }}">
                    </a>
        
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/{{ Auth::user()->nickname }}">Profile</a>
                        <a class="dropdown-item text-danger" href="{{ url('/logout') }}">Logout</a>
                        <div class="dropdown-divider"></div>
                        <div class="es-social-icons text-center mt-2">
                            <a target="_blank" rel="nofollow" href="https://twitter.com/eyeshothq">
                                <i class="fab fa-twitter mx-1"></i>
                            </a>
                            <a target="_blank" rel="nofollow" href="https://facebook.com/eyeshothq">
                                <i class="fab fa-facebook mx-1"></i>
                            </a>
                            <a target="_blank" rel="nofollow" href="https://github.com/actuallyakash/eyeshot">
                                <i class="fab fa-github mx-1"></i>
                            </a>
                            <a target="_blank" rel="nofollow" href="https://eyeshothq.tumblr.com/">
                                <i class="fab fa-tumblr-square mx-1"></i>
                            </a>
                        </div>
                    </div>
                    @else
                    <button class="btn btn-success mt-1" type="submit" data-toggle="modal" data-target="#loginSignupTv">Start Exploring</button>
                    @endauth
                </li>
            </ul>
        </div>
    </nav>
</header>
