<div id="landing-pano" class="map-box">
    <div style="display:none;" class="loader text-center"><span class="eyeshot-loader">🌏</span></div>
    <div style="display:none;" id="sv-pano">
        <div id="sv-map"></div>
        <div class="action-buttons">
            <button class="randomize-eyeshot btn btn-link" data-tooltip="tooltip" data-placement="left" title="Randomizer"><i class="fas fa-random"></i></button>
            @auth    
            {{-- Dont' use classes starting from 'fav-', a fix is done in js --}}
            <button class="unfavourite-sv btn btn-link cta-street-view" data-tooltip="tooltip" data-placement="top" title="Like"><i class="far fa-heart"></i></button>
            @else
            <button data-toggle="modal" data-target="#loginSignupTv" data-tooltip="tooltip" data-placement="top" title="Favourite" class="btn btn-link"><i class="far fa-heart"></i></button>
            @endauth
            <button class="share-eyeshot btn btn-link" data-tooltip="tooltip" data-placement="right" title="Share"><i class="fas fa-share-alt"></i></button>
        </div>
    </div>
</div>
{{-- <span class="first-explorer">Discovered by: <span class="pioneer"></span></span> --}}
@guest
<div class="text-center wtf-eyeshot">
    <h1>What is StreetviewHub?</h1>
    <div class="d-flex justify-content-around align-items-center description">
        <div class="globe-eyeshot display-3 mr-3">🌏</div>
        <div class="explain-eyeshot text-justify">StreetviewHub is a visual discovery of the world around us, explored by people like you. It's Random Street View on Steroids.</div>
    </div>
</div>

<div class="row eyeshot-controls text-center bg-white p-3 px-5">
    <div class="col-sm control-box">
        <i class="fas fa-random"></i>
        <h4>Randomizer</h4>
        <p class="text-muted">Explore some place randomly and let your curious brain wander.</p>
    </div>
    <div class="col-sm control-box">
        <i class="far fa-heart"></i>
        <h4>Favourite</h4>
        <p class="text-muted">Found something awesome? Don't loose the place, favourite it and it'll be shared with the community.</p>
    </div>
    <div class="col-sm control-box">
        <i class="fas fa-share-alt"></i>
        <h4>Share</h4>
        <p class="text-muted">Share directly with your friends in a click of a button.</p>
    </div>
</div>
@endguest

<div class="text-center">
    <h1>Some Cool Streetviews 😎</h1>
</div>
@include('feed/latest-shots')

@include('components.newsletter')

@include('layouts/footer')