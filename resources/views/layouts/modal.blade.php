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
<div class="modal" id="favouriteBox" tabindex="-1" role="dialog" aria-labelledby="favouriteModal"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            
            <div class="modal-body text-center">
                <h5 class="location-title">Great find</h5>
                <p class="font-weight-light">Add more info so other users can see it too</p>
                <div class="container">
                    <div class="form-group">
                        <textarea class="form-control m-3" placeholder="Why favourite?" rows="3"></textarea>
                    
                        <input type="text" class="form-control m-3" placeholder="Tags">

                        <button type="submit" class="btn btn-success m-3 btn-fav-info">Done</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endauth
