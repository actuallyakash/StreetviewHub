@if ( !Auth::user() )
<div class="modal" id="loginSignupTv" tabindex="-1" role="dialog" aria-labelledby="startExploringModal"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-body text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="startExploringModal">Welcome to StreetView</h5>
                <p class="font-weight-light"> Sign in below to explore new places and share it with the community. </p>
                <div class="row mt-4">
                    <div class="col">
                        <a class="btn btn-lg btn-outline-success" href="/auth/google/">Google</a>
                    </div>
                    <div class="col">
                        <a class="btn btn-lg btn-outline-primary" href="/auth/twitter/">Twitter</a>
                    </div>
                    <div class="col">
                        <a class="btn btn-lg btn-outline-dark" href="/auth/github/">GitHub</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@auth

<div class="modal fade" id="favouriteBox">
    <div class="modal-dialog modal-dialog-centered modal-es-size">
        <div class="modal-content">            
            <form class="fav-shot" id="favLocation">
                <div class="modal-header">
                    <h3 class="text-center mx-auto">Great Find</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2 text-center eyeshot-avatar">
                            <img src="{{ Auth::user()->avatar }}">
                            <h6 class="user-nickname">{{ Auth::user()->nickname }}</h6>
                        </div>
                        <div class="col-md-10 eyeshot-section">
                            <textarea name="status" class="form-control status descriptionInput" placeholder="Wanna describe? (Optional)" rows="5" autofocus></textarea>
                            <div class="divider"></div>
                            <input name="tags" type="text" placeholder="Tags (Optional)">
                            <div class="d-flex post-eyeshot">
                                <button type="submit" class="btn btn-primary btn-mini ml-auto btn-fav-info">
                                    Post
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <ul class="list-unstyled">
                        <li>Go ahead & describe what's happening 📋</li>
                        <li>Use tags for efficient categorization 🏷</li>
                        <li>Keep exploring 🗺</li>
                        <li>You never know where you'll end up 😍</li>
                        <li class="mt-3"><strong>'Cause you take me places I've never been - <a target="_blank" rel="nofollow" href="https://www.youtube.com/watch?v=2dufPBL-pLU">Mark Wills</a></strong></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="toast toast-location-share toast-success">
    <div class="toast-body">
        <button type="button" class="close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        😍 Awesome. Thankyou for sharing with the community.
    </div>
</div>

<div class="toast sv-not-found toast-danger">
    <div class="toast-body">
        <button type="button" class="close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        🚧 No view found
    </div>
</div>

@endauth

<div class="modal" id="viewEyeshot" tabindex="-1" role="dialog" aria-labelledby="view-eyeshot" aria-hidden="true">
    <button type="button" class="close close-eyeshot-icon" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content text-center">
            <h5 class="eyeshot-location"></h5>
            <div style="display:none;" class="loader text-center m-5"><span class="eyeshot-loader">🌏</span></div>
            <div style="display:none;" id="sv-pano">
                <div id="sv-map"></div>
                <div class="action-buttons">
                    @auth
                        {{-- Dont' use classes starting from 'fav-', a fix is done in js --}}
                        <button class="unfavourite-sv btn btn-link cta-street-view" data-tooltip="tooltip" data-placement="top" title="Like">
                            <i class="far fa-heart"></i>
                        </button>
                        <button data-tooltip="tooltip" data-placement="top" title="Share" class="btn btn-link"><i class="fas fa-share-alt"></i></button>
                    @else
                        <button data-toggle="modal" data-target="#loginSignupTv" data-tooltip="tooltip" data-placement="top" title="Favourite" class="btn btn-link"><i class="far fa-heart"></i></button>
                        <button data-tooltip="tooltip" data-placement="top" title="Share" class="btn btn-link"><i class="fas fa-share-alt"></i></button>
                    @endauth
                    
                </div>
            </div>
            <div class="eyeshot-status"></div>
            <div class="eyeshot-tags"></div>
        </div>
    </div>
</div>

<div class="modal" id="shareEyeshot" tabindex="-1" role="dialog" aria-labelledby="share-eyeshot" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <a target="_blank" class="share-facebook" href="https://www.facebook.com/sharer/sharer.php?u=http://eyeshot.xyz/eyeshot/hahaha">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a target="_blank" class="share-twitter" href="https://twitter.com/share?url=http://eyeshot.xyz/eyeshot/hahaha&via=eyeshot.xyz&text=roamingAtUnknownPlace">
                    <i class="fab fa-twitter"></i>
                </a>

                <div class="share-url mt-4">
                    <input onclick="this.select();" type="text" value="http://eyeshot.xyz/hahaha" class="form-control eyeshot-url" placeholder="URL" readonly>
                    
                    <button class="btn btn-link copy-eyeshot-url"><i class="far fa-copy"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>