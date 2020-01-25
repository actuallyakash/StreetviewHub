<header class="shadow">
    {{-- Desktop Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Eyeshot</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#openXsNav"
            aria-controls="openXsNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-center" id="openXsNav">
            
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-flex justify-content-center">
                    <form class="form-search" action="/search" method="get">
                        <input type="text" class="search-input" name="q" placeholder="Search for Eyeshot or Location">
                        <span class="search-icon">
                            <button class="button-icon">🔍</button>
                        </span>
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/feed">Feed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/categories">Categories</a>
                </li>
                <li class="nav-item">
                    @auth
                    <a class="btn btn-outline-danger" href="{{ url('/logout') }}">Logout</a>
                    @else
                    <button class="btn btn-outline-success" type="submit" data-toggle="modal" data-target="#loginSignupTv">Start
                        Exploring</button>
                    @endauth
                </li>
            </ul>
        </div>
    </nav>
</header>
