<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GA_ID') }}"></script>
    <script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '{{ env('GA_ID') }}');</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- For SEO --}}
    <link rel="canonical" href="{{ Request::url() }}" />
    <meta property="og:site_name" content="Eyeshot" />
@if ( \Request::input('s') )
    <meta name="description" content="Eyeshot is a visual discovery of our surroundings, explored by people like you. Discover the World's Top Destinations and Cool Places.">
    <meta class="meta-keywords" name="keywords" content="">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta class="meta-title" property="og:title" content="" />
    <meta class="meta-image" property="og:image" content="">
    <meta property="og:description" content="Eyeshot is a visual discovery of our surroundings, explored by people like you. Discover the World's Top Destinations and Cool Places." />
    <meta name="twitter:site" content="@eyeshotXYZ">
    <meta class="meta-title" name="twitter:title" content="">
    <meta name="twitter:description" content="Eyeshot is a visual discovery of our surroundings, explored by people like you. Discover the World's Top Destinations and Cool Places.">
    <meta class="meta-image" name="twitter:image:src" content="">
    <meta name="twitter:card" content="summary_large_image">
@elseif( isset($user) && Request::url() == url($user->nickname) )
    <meta property="og:type" content="profile" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="profile:username" content="{{ $user->nickname }}" />
    <meta property="og:title" content="{{ $user->nickname . " | Eyeshot Profile" }}" />
    @if ( $user->bio )
    <meta name="description" content="{{ $user->bio }}">
    <meta property="og:description" content="{{ $user->bio }}" />
    <meta name="twitter:description" content="{{ $user->bio }}">
    @endif
    <meta name="twitter:site" content="@eyeshotXYZ">
    <meta name="twitter:creator" content="{{ $user->nickname }}">
    <meta name="twitter:title" content="{{ $user->nickname . " | Eyeshot Profile" }}">
@else
    <meta name="description" content="Eyeshot is a visual discovery of our surroundings, explored by people like you. Discover the World's Top Destinations and Cool Places.">
    <meta name="keywords" content="eyeshot,street view,panorama,360 view,top destinations,google street view">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:title" content="" />
    <meta property="og:image" content="">
    <meta property="og:description" content="Eyeshot is a visual discovery of our surroundings, explored by people like you. Discover the World's Top Destinations and Cool Places." />
    <meta name="twitter:site" content="@eyeshotXYZ">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="Eyeshot is a visual discovery of our surroundings, explored by people like you. Discover the World's Top Destinations and Cool Places.">
    <meta name="twitter:image:src" content="">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="alternate" type="application/rss+xml" title="Eyeshot Feed" href="https://eyeshot.xyz/feed" />
@endif
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- env('GOOGLE_ID') --}}
    <meta name="google-signin-client_id" content="962729632216-407dsmg76fhpt93g5e26qkm8m626csac.apps.googleusercontent.com">
    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}"">
    <title>@yield('title', 'Eyeshot - Discover the World\'s Top Destinations & Cool Places')</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/tagify.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/5ac1289fea.js" crossorigin="anonymous"></script>

</head>
    <body>
        @include('layouts.navbar')
        
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
    <script src="{{ asset('js/index.min.js') }}" async defer></script>
    <script src="{{ asset('js/jscroll.min.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GMAPS_KEY') }}"></script>
</body>
</html>
