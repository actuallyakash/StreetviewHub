@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="eyeshot-feed text-center py-4">
        
        <div class="row">

            @foreach ( $eyeshots as $shot )
            <div class="col-md-4 col-sm-6">
                <div class="eyeshot mb-4 shadow-sm">

                    <div class="eyeshot-image">
                        <a class="eyeshot-link" href="#">
                        <picture>
                            <source srcset="https://via.placeholder.com/400x300" media="(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-device-pixel-ratio: 1.5), (min-resolution: 1.5dppx)">
                            <source srcset="https://via.placeholder.com/400x300">
                            <img class="img-fluid" alt="" src="https://via.placeholder.com/400x300">
                        </picture>
                        </a>
                    </div>
                    
                    <div class="eyeshot-details slide-up">
                        <p class="card-text eyeshot-location">{{ $shot->location_name }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img class="eyeshot-avatar" src="{{ $shot->owner->avatar }}">
                                <p class="eyeshot-username">{{ $shot->owner->name }}</p>
                            </div>
                            <small class="text-muted">{{ $shot->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            
        </div>
    
        {{-- <div class="row eyeshots">
            <div class="col-md-4 col-xs-6">
                <div class="eyeshot">
                    <div class="eyeshot-image">
                        <a class="eyeshot-link" href="#">
                        <picture>
                            <source srcset="https://via.placeholder.com/400x300" media="(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-device-pixel-ratio: 1.5), (min-resolution: 1.5dppx)">
                            <source srcset="https://via.placeholder.com/400x300">
                            <img alt="" src="https://via.placeholder.com/400x300">
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
                            <source srcset="https://via.placeholder.com/400x300" media="(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-device-pixel-ratio: 1.5), (min-resolution: 1.5dppx)">
                            <source srcset="https://via.placeholder.com/400x300">
                            <img alt="" src="https://via.placeholder.com/400x300">
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
                            <source srcset="https://via.placeholder.com/400x300" media="(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-device-pixel-ratio: 1.5), (min-resolution: 1.5dppx)">
                            <source srcset="https://via.placeholder.com/400x300">
                            <img alt="" src="https://via.placeholder.com/400x300">
                        </picture>
                        </a>
                    </div>
                </div>
            </div>

        </div> --}}

    </div>
</div>
@endsection
