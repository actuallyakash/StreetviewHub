@if ( !Auth::user() )
<div class="modal" id="loginSignupTv" tabindex="-1" role="dialog" aria-labelledby="startExploringModal"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="startExploringModal">Welcome to Eyeshot 🌏</h5>
                <p class="font-weight-light"> Discover the world’s top Destinations & Cities </p>
                <h3>Sign in with</h3>
                <div class="row mt-4 social-login">
                    <div class="col auth-social">
                        <a class="btn btn-lg btn-outline-dark" href="/auth/google/">
                            <i class="fab fa-google mr-2"></i> Google
                        </a>
                    </div>
                    <div class="col auth-social">
                        <a class="btn btn-lg btn-outline-twitter" href="/auth/twitter/">
                            <i class="fab fa-twitter mr-2"></i> Twitter
                        </a>
                    </div>
                    <div class="col auth-social">
                        <a class="btn btn-lg btn-outline-dark" href="/auth/github/">
                            <i class="fab fa-github mr-2"></i> GitHub
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="loginSignupModal" tabindex="-1" role="dialog" aria-labelledby="startExploringModal"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content p-4">
            <button style="position: absolute;right: 15px;top: 6px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body text-center">
                <h5 class="modal-title" id="startExploringModal">We like your curiosity!</h5>
                <p class="font-weight-light"> Create an account to receive great eyeshots in your inbox and find locations that you will love 💕. </p>
                <div class="row mt-4 social-login">
                    <div class="col auth-social">
                        <a class="btn btn-lg btn-outline-dark" href="/auth/google/">
                            <i class="fab fa-google mr-2"></i> Google
                        </a>
                    </div>
                    <div class="col auth-social">
                        <a class="btn btn-lg btn-outline-twitter" href="/auth/twitter/">
                            <i class="fab fa-twitter mr-2"></i> Twitter
                        </a>
                    </div>
                    <div class="col auth-social">
                        <a class="btn btn-lg btn-outline-dark" href="/auth/github/">
                            <i class="fab fa-github mr-2"></i> GitHub
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@auth

<div class="modal" id="favouriteBox" tabindex="-1" role="dialog" aria-labelledby="favourite-eyeshot" aria-hidden="true">
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
                            <img src="{{ str_replace(["https://", "http://"], "https://", Auth::user()->avatar ) }}">
                            <h6 class="user-nickname">{{ Auth::user()->nickname }}</h6>
                        </div>
                        <div class="col-md-10 eyeshot-section">
                            <input class="form-control eyeshot-title" name="title" type="text" placeholder="Eyeshot Title">
                            <div class="divider"></div>
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

@isset($eyeshots)
<div class="modal" id="viewEyeshot" tabindex="-1" role="dialog" aria-labelledby="view-eyeshot" aria-hidden="true">
    <button type="button" class="close close-eyeshot-icon" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        
        <div style="display:none;" class="loader text-center m-5"><span class="eyeshot-loader">🌏</span></div>

        <div style="display:none;" class="modal-content">

            <div class="d-flex align-items-center eyeshot-header">
                <div class="eyeshot-avatar">
                    <img src="">
                </div>
                <div class="eyeshot-user">
                    <p class="eyeshot-title"></p>
                    <p class="eyeshot-username"></p>
                </div>
            </div>

            <div id="sv-pano">
                <div id="sv-map"></div>
                <div class="action-buttons">
                    @auth
                        {{-- Dont' use classes starting from 'fav-', a fix is done in js --}}
                        <button class="unfavourite-sv btn btn-link cta-street-view" data-tooltip="tooltip" data-placement="top" title="Like">
                            <i class="far fa-heart"></i>
                        </button>
                    @else
                        <button data-toggle="modal" data-target="#loginSignupTv" data-tooltip="tooltip" data-placement="top" title="Favourite" class="btn btn-link"><i class="far fa-heart"></i></button>
                    @endauth
                    <button class="share-eyeshot btn btn-link" data-tooltip="tooltip" data-placement="right" title="Share"><i class="fas fa-share-alt"></i></button>                    
                </div>
            </div>
            
            <div class="row eyeshot-details">
                <div class="col-md-7">
                    <div class="eyeshot-status"></div>
                </div>
                <div class="col-md-5 eyeshot-meta">
                    {{-- <div class="d-flex justify-content-around social-share">
                        <a href="#" class="btn btn-outline-pinterest btn-sm">Pin</a>
                        <a href="#" class="btn btn-outline-twitter btn-sm">Twitter</a>
                        <a href="#" class="btn btn-outline-facebook btn-sm">Facebook</a>
                        <a href="#" class="btn btn-outline-dark btn-sm">Copy</a>
                    </div> --}}
                    <div class="d-flex">
                        <i class="m-2 fas fa-tag"></i>
                        <div class="eyeshot-tags"></div>
                    </div>
                    <div class="d-flex">
                        <i class="m-2 fas fa-map-marker-alt"></i>
                        <div class="eyeshot-location mt-1 ml-2"></div>
                    </div>
                    <div class="d-flex">
                        <i class="m-2 fas fa-calendar"></i>
                        <div class="eyeshot-published mt-1 ml-2"></div>
                    </div>
                    <div class="d-flex">
                        <i class="m-2 fas fa-folder-plus"></i>
                        <div class="eyeshot-saves mt-1 ml-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endisset

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

{{-- PWA --}}
<div id="pwa-snackbar" class="pwa-notif py-4">
    <button type="button" class="close" data-dismiss="pwa-notif" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="pwa-body p-2" role="alert">
        <span class="pwa-tag flex px-2 py-1 mr-3">INSTALL ( < 1 MB )</span>
        <span class="pwa-msg mr-2">Get the app and explore coolest locations 🌍 </span>
    </div>
</div>