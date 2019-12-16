<div class="user-card d-flex justify-content-center">
    <div class="mb-3" style="max-width: 540px;">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ $user->avatar }}" class="card-img rounded-circle" alt="...">
            </div>
            <div class="col-md-8 d-flex align-items-center">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->nickname }}</h5>
                    <p class="card-text">{{ $user->bio }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
