<div id="shared-pano" class="map-box">
    <div id="sv-pano">
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
<p class="first-explorer">Discovered by: <span class="pioneer"></span></p>