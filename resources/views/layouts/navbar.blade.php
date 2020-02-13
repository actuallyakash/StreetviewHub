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
                
                <li class="nav-item eyeshot-user">
                    @auth
                    {{-- <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ ucfirst(Auth::user()->name) }} <i class="fas fa-chevron-down"></i>
                    </a> --}}

                    <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img class="eyeshot-user" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                    </a>
        
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/{{ Auth::user()->nickname }}">Profile</a>
                        <a class="dropdown-item text-danger" href="{{ url('/logout') }}">Logout</a>
                    </div>
                    @else
                    <button class="btn btn-success mt-1" type="submit" data-toggle="modal" data-target="#loginSignupTv">Start Exploring</button>
                    @endauth
                </li>
                
                @auth
                <li class="nav-item">
                    <a href="/" class="btn button-es mt-1">Explore Now</a>
                </li>
                @endauth
            </ul>
        </div>
    </nav>
</header>
