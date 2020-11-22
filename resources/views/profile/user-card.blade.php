<div class="user-card d-flex justify-content-center mt-4">
    <div style="max-width: 540px;">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ str_replace(["https://", "http://"], "https://", $user->avatar ) }}" class="card-img rounded-circle" alt="{{ $user->nickname }}">
            </div>
            <div class="col-md-8 d-flex align-items-center">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->nickname }}</h5>
                    <p class="card-text">{{ $user->bio }}</p>
                </div>
            </div>
        </div>
        <ul class="list-inline text-center profile-nav">
            <a class="active" href="#">
                <li class="list-inline-item">
                    {{ count($user->eyeshots) }}<br>
                    <span class="text-muted">Streetviews</span>                     
                </li>
            </a>
        </ul>
    </div>
</div>
