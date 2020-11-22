<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.ga.id') }}"></script>
    <script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag("config", "{{ config('services.ga.id') }}");</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- For SEO --}}
    <link rel="canonical" href="{{ Request::url() }}" />
    {{-- For PWA --}}
    <link href="{{ asset('manifest.json') }}" rel="manifest"/>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <meta name="theme-color" content="#6697FE">

    <meta property="og:site_name" content="StreetviewHub" />
@if ( \Request::input('s') )
    <meta name="description" content="Random Streetviews on Steroids. Discover the World's Top Destinations and Cool Places.">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta class="meta-title" property="og:title" content="StreetviewHub - Random Streetviews on Steroids 🚀" />
    <meta class="meta-image" property="og:image" content="https://eyeshot.s3.amazonaws.com/cover.png">
    <meta property="og:description" content="Random Streetviews on Steroids. Discover the World's Top Destinations and Cool Places." />
    <meta name="twitter:site" content="@streetviewhub">
    <meta class="meta-title" name="twitter:title" content="StreetviewHub">
    <meta name="twitter:description" content="Random Streetviews on Steroids. Discover the World's Top Destinations and Cool Places.">
    <meta class="meta-image" name="twitter:image:src" content="https://eyeshot.s3.amazonaws.com/cover.png">
    <meta name="twitter:card" content="summary_large_image">
@elseif( isset($user) && Request::url() == url($user->nickname) )
    <meta property="og:type" content="profile" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="profile:username" content="{{ $user->nickname }}" />
    <meta property="og:title" content="{{ $user->nickname . " | StreetviewHub Profile" }}" />
    @if ( $user->bio )
    <meta name="description" content="{{ $user->bio }}">
    <meta property="og:description" content="{{ $user->bio }}" />
    <meta name="twitter:description" content="{{ $user->bio }}">
    @endif
    <meta name="twitter:site" content="@streetviewhub">
    <meta name="twitter:creator" content="{{ $user->nickname }}">
    <meta name="twitter:title" content="{{ $user->nickname . " | StreetviewHub Profile" }}">
@elseif( isset($user) && isset($eyeshot) )
    <meta name="description" content="{{ $eyeshot->status !== null ? $eyeshot->status : "Random Streetviews on Steroids. Discover the World's Top Destinations and Cool Places." }}">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:title" content="{{ $eyeshot->title !== null ? $eyeshot->title : "Explored by " . $user->nickname }}" />
    <meta property="og:image" content="{{ Storage::disk('s3')->url($eyeshot->media) }}" />
    <meta property="og:description" content="{{ $eyeshot->status !== null ? $eyeshot->status : "Random Streetviews on Steroids. Discover the World's Top Destinations and Cool Places." }}" />
    <meta name="twitter:site" content="@streetviewhub">
    <meta name="twitter:title" content="{{ $eyeshot->title !== null ? $eyeshot->title : "Explored by " . $user->nickname }}" />
    <meta name="twitter:description" content="{{ $eyeshot->status !== null ? $eyeshot->status : "Random Streetviews on Steroids. Discover the World's Top Destinations and Cool Places." }}" />
    <meta name="twitter:image:src" content="{{ Storage::disk('s3')->url($eyeshot->media) }}" />
    <meta name="twitter:card" content="summary_large_image">
    <link rel="alternate" type="application/rss+xml" title="{{ "Explored by @" . $user->nickname  }}" href="{{ Request::url() }}" />
@elseif ( \Request::getRequestUri() == '/placeholder' )
    <meta name="description" content="StreetviewHub's Placeholder are the random, beautiful, and cool images from Google Street View explored by people on StreetviewHub.">
    <meta property="og:title" content="StreetviewHub's Placeholder are the random, beautiful, and cool images from Google Street View explored by people on StreetviewHub." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:image" content="https://eyeshot.s3.amazonaws.com/cover.png">
    <meta property="og:description" content="StreetviewHub's Placeholder are the random, beautiful, and cool images from Google Street View explored by people on StreetviewHub." />
    <meta name="twitter:site" content="@streetviewhub">
    <meta class="meta-title" name="twitter:title" content="StreetviewHub Placeholder API">
    <meta name="twitter:description" content="StreetviewHub Placeholder are the random, beautiful, and cool images from Google Street View explored by people on StreetviewHub.">
    <meta name="twitter:image:src" content="https://eyeshot.s3.amazonaws.com/cover.png">
@else
    <meta name="description" content="Random Streetviews on Steroids. Discover the World's Top Destinations and Cool Places.">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:title" content="StreetviewHub - Random Streetviews on Steroids 🚀" />
    <meta property="og:image" content="https://eyeshot.s3.amazonaws.com/cover.png">
    <meta property="og:description" content="Random Streetviews on Steroids. Discover the World's Top Destinations and Cool Places." />
    <meta name="twitter:site" content="@streetviewhub">
    <meta name="twitter:title" content="StreetviewHub - Random Streetviews on Steroids 🚀">
    <meta name="twitter:description" content="Random Streetviews on Steroids. Discover the World's Top Destinations and Cool Places.">
    <meta name="twitter:image:src" content="https://eyeshot.s3.amazonaws.com/cover.png">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="alternate" type="application/rss+xml" title="StreetviewHub Feed" href="https://streetviewhub.com/feed" />
@endif
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <meta name="google-signin-client_id" content="{{ config('services.ga.google_id') }}">
    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}"">
    <title>@yield( "title", "StreetviewHub - Random Streetviews on Steroids 🚀" )</title>
    <link href="{{ asset('css/style.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/tagify.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/5ac1289fea.js" crossorigin="anonymous"></script>
    <script>(function(h,o,t,j,a,r){h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};h._hjSettings={hjid:1774879,hjsv:6};a=o.getElementsByTagName('head')[0];r=o.createElement('script');r.async=1;r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;a.appendChild(r);})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');</script>
</head>
    <body>
        @include('layouts.navbar')
        
        <main class="sv-app">
            <div id="content">
                @yield('content')
            </div>
        </main>

        @include('layouts.modal')

    @if ( ! Request::url('/') )
        @include('components.newsletter')
    @endif

    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/tagify.min.js') }}"></script>
    <script> var key = "{!! config('services.gmaps_key') !!}"; </script>
    <script src="{{ asset('js/index.min.js') }}" async defer></script>
    <script src="{{ asset('js/jscroll.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.gmaps_key') }}"></script>
</body>
</html>
