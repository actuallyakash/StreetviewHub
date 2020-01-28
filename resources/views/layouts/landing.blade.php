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
<p class="first-explorer">Discovered by: <span class="pioneer"></span></p>

<div class="text-center wtf-eyeshot">
    <h1>What is Eyeshot?</h1>
    <div class="d-flex justify-content-around align-items-center description">
        <div class="globe-eyeshot display-2 mr-3">🌏</div>
        <div class="explain-eyeshot text-justify">Eyeshot is a visual discovery of our surroundings, explored by people like you. Eyeshot's content comes from two sources - Google and explorers (you). Contribute to Eyeshot by exploring places you never been before.</div>
    </div>

    <div class="eyeshot-testimonial mt-5">
        <h2>Testimonial</h2>
        <blockquote class="mt-3"><strong>'Cause you take me places that I've never been - <a target="_blank" rel="nofollow" href="https://www.youtube.com/watch?v=2dufPBL-pLU">Mark Wills</a></strong></blockquote>
    </div>

    <div class="random-eyeshots mt-5">
        <h3>Some Random Eyeshots</h3>
    </div>
</div>