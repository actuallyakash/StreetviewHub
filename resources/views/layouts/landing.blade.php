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

@include('feed/latest-shots')

<footer class="home-footer container py-4">
    <div class="row justify-content-between align-items-center footer-content">
        {{-- <div class="col-12 col-md-4 text-center order-1">
            <ul class="es-social-icons list-inline text-center m-4">
                <li class="list-inline-item">
                    <a target="_blank" rel="noopener" href="https://twitter.com/eyeshot"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                </li>
                <li class="list-inline-item">
                    <a target="_blank" rel="noopener" href="https://instagram.com/eyeshot"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div> --}}
        <div class="text-center order-1">
            <a class="footer-brand" href="/">Eyesh<span class="logo-globe">🌍</span>t</a>
            <small class="d-block mb-3 text-muted">© 2020</small>
        </div>
        <div class="text-center order-3 order-sm-2">
            <h5>See inside</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="/feed">Feed 📜</a></li>
                <li><a class="text-muted" href="/popular">On fire 🔥</a></li>
                <li><a class="text-muted" href="/privacy">Privacy 🔏</a></li>
                {{-- Can't afford business email right now, in future maybe 🤷‍♂️ --}}
                <li><a class="text-muted" href="mailto:eyeshot.xyz@gmail.com">Contact 👋</a></li>
                <li><a class="text-muted" href="https://github.com/actuallyakash/eyeshot">Github 👨‍💻</a></li>
            </ul>
        </div>
    </div>
</footer>