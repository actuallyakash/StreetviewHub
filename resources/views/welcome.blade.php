@extends('layouts.app')
@section('content')
<div class="map-box">
    <div id="sv-pano">
        <div id="sv-map"></div>
        <div class="action-buttons">
            @auth
                <button id="randomize-street-view" data-tooltip="tooltip" data-placement="left" title="Randomizer" class="btn btn-link"><i class="fas fa-random"></i></button>
                <button id="favourite-street-view" data-tooltip="tooltip" data-placement="top" title="Favourite" class="btn btn-link"><i class="far fa-heart"></i></button>
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