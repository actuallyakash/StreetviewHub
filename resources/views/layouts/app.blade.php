<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- env('GOOGLE_ID') --}}
    <meta name="google-signin-client_id" content="962729632216-407dsmg76fhpt93g5e26qkm8m626csac.apps.googleusercontent.com">
    
    <title>@yield('title', 'Street View')</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/tagify.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

</head>
    <body>
        <header>
            {{-- Desktop Navbar --}}
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Street View</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#openXsNav"
                    aria-controls="openXsNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="openXsNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="/feed">Feed</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Dropdown
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                    </ul>

                    @auth
                    <a class="btn btn-outline-danger" href="{{ url('/logout') }}">Logout</a>
                    @else
                    <button class="btn btn-outline-success" type="submit" data-toggle="modal" data-target="#loginSignupTv">Start Exploring</button>
                    @endauth
                </div>
            </nav>
        </header>
        
        <main class="sv-app">
            <div id="content">
                @yield('content')
            </div>
        </main>

    @include('layouts.modal')

    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/popper.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/tagify.min.js') }}"></script>
    <script src="{{ asset('js/index.js') }}" async defer></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBD52XR31rIk-MaE6AKlj_pLYlKxeJGUBQ&callback=initMap"></script>
</body>
</html>
