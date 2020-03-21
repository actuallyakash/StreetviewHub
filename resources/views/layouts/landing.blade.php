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

<div class="text-center wtf-eyeshot">
    <h1>What is Eyeshot?</h1>
    <div class="d-flex justify-content-around align-items-center description">
        <div class="globe-eyeshot display-3 mr-3">🌏</div>
        <div class="explain-eyeshot text-justify">Eyeshot is a visual discovery of the world around us, explored by people like you. Eyeshot's content comes from two sources - Google and explorers (you). Contribute to Eyeshot by exploring places you never been before.</div>
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

@include('feed/latest-shots')

<footer class="home-footer mt-3 bg-white text-center p-3">
    <a class="footer-brand" href="http://eyeshot.xyz">Eyesh<span class="logo-globe">🌍</span>t</a>
    <ul class="list-inline nav-list mt-1">
        <li class="list-inline-item"><a class="text-muted" href="/feed">📜 Feed</a></li>
        <li class="list-inline-item"><a class="text-muted" href="/popular">🔥 On fire</a></li>
        <li class="list-inline-item"><a class="text-muted" href="/privacy">🔏 Privacy</a></li>
        {{-- Can't afford business email right now, in future maybe 🤷‍♂️ --}}
        <li class="list-inline-item"><a class="text-muted" href="mailto:eyeshot.xyz@gmail.com">👋 Contact</a></li>
    </ul>

    <small class="text-muted">👨‍💻 Eyeshot is Open Source @ <a target="_blank" rel="nofollow" href="https://github.com/actuallyakash/eyeshot">GitHub</a></small>

    <div class="es-social-icons text-center mt-2">
        <a target="_blank" rel="nofollow" href="https://twitter.com/eyeshothq">
            <i class="fab fa-twitter mx-2"></i>
        </a>
        <a target="_blank" rel="nofollow" href="https://facebook.com/eyeshothq">
            <i class="fab fa-facebook"></i>
        </a>
    </div>
</footer>