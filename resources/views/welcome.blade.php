@extends('layouts.app')
@section('content')
<div class="map-box">
    <div id="sv-pano">
        <div id="sv-map"></div>
        <div class="action-buttons">
            @auth
                <button class="randomize-street-view btn btn-link" data-tooltip="tooltip" data-placement="left" title="Randomizer"><i class="fas fa-random"></i></button>

                <button class="favourite-street-view btn btn-link" data-tooltip="tooltip" data-placement="top" title="Favourite">
                    <i class="far fa-heart"></i>
                </button>

                <button data-tooltip="tooltip" data-placement="right" title="Bookmark" class="btn btn-link"><i class="far fa-bookmark"></i></button>
            @else
                <button data-toggle="modal" data-target="#loginSignupTv" data-tooltip="tooltip" data-placement="left" title="Randomizer" class="btn btn-link"><i class="fas fa-random"></i></button>
                <button data-toggle="modal" data-target="#loginSignupTv" data-tooltip="tooltip" data-placement="top" title="Favourite" class="btn btn-link"><i class="far fa-heart"></i></button>
                <button data-toggle="modal" data-target="#loginSignupTv" data-tooltip="tooltip" data-placement="right" title="Bookmark" class="btn btn-link"><i class="far fa-bookmark"></i></button>
            @endauth
            
        </div>
    </div>
</div>
@endsection