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
                    <form id="favLocation">
                        <div class="form-group">
                            <textarea name="status" class="form-control status" placeholder="Why favourite? (Optional)" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <input name="tags" type="text" class="form-control" placeholder="Tags (Optional)">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-fav-info">Done</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

  <div class="toast" style="position: absolute; top: 20px; right: 0;">
    <div class="toast-header">
      <img src="..." class="rounded mr-2" alt="...">
      <strong class="mr-auto">Bootstrap</strong>
      <small>11 mins ago</small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
  </div>
@endauth
