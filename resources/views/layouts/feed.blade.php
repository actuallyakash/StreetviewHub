@extends('layouts.app')

@section('content')

@include('feed/topbar')

<div class="container-fluid">
    <div class="eyeshot-feed text-center py-4">
        
        <div class="row">

            @foreach ( $eyeshots as $eyeshot )
            <div class="col-md-4 col-sm-6">
                @include('components/eyeshot')
            </div>
            @endforeach

            
        </div>
    
        {{-- <div class="row eyeshots">
            <div class="col-md-4 col-xs-6">
                <div class="eyeshot">
                    <div class="eyeshot-image">
                        <a class="eyeshot-link" href="#">
                        <picture>
                            <source srcset="{{ asset("storage/eyeshots/$shot->media") }}" media="(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-device-pixel-ratio: 1.5), (min-resolution: 1.5dppx)">
                            <source srcset="{{ asset("storage/eyeshots/$shot->media") }}">
                            <img alt="" src="https://maps.googleapis.com/maps/api/streetview?size=400x300&pano={{ $shot->pano_id }}&heading={{ $sfov={{ $zoomLevel }}&hot->pano_heading }}&pitch={{ $shot->pano_pitch }}&key=AIzaSyBD52XR31rIk-MaE6AKlj_pLYlKxeJGUBQ">
                        </picture>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-6">
                <div class="eyeshot">
                    <div class="eyeshot-image">
                        <a class="eyeshot-link" href="#">
                        <picture>
                            <source srcset="{{ asset("storage/eyeshots/$shot->media") }}" media="(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-device-pixel-ratio: 1.5), (min-resolution: 1.5dppx)">
                            <source srcset="{{ asset("storage/eyeshots/$shot->media") }}">
                            <img alt="" src="https://maps.googleapis.com/maps/api/streetview?size=400x300&pano={{ $shot->pano_id }}&heading={{ $sfov={{ $zoomLevel }}&hot->pano_heading }}&pitch={{ $shot->pano_pitch }}&key=AIzaSyBD52XR31rIk-MaE6AKlj_pLYlKxeJGUBQ">
                        </picture>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-6">
                <div class="eyeshot">
                    <div class="eyeshot-image">
                        <a class="eyeshot-link" href="#">
                        <picture>
                            <source srcset="{{ asset("storage/eyeshots/$shot->media") }}" media="(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-device-pixel-ratio: 1.5), (min-resolution: 1.5dppx)">
                            <source srcset="{{ asset("storage/eyeshots/$shot->media") }}">
                            <img alt="" src="https://maps.googleapis.com/maps/api/streetview?size=400x300&pano={{ $shot->pano_id }}&heading={{ $sfov={{ $zoomLevel }}&hot->pano_heading }}&pitch={{ $shot->pano_pitch }}&key=AIzaSyBD52XR31rIk-MaE6AKlj_pLYlKxeJGUBQ">
                        </picture>
                        </a>
                    </div>
                </div>
            </div>

        </div> --}}

    </div>
</div>
@endsection
