<div class="eyeshot mb-4 shadow-sm eyeshot-{{ $eyeshot->id }}">
    <div class="eyeshot-image">
        <a class="eyeshot-link" href="#">
            @if ( $eyeshot->user_id == $eyeshot->pioneer)
            <span class="pioneer"><i class="fas fa-medal"></i></span>
            @endif
            <picture>
                <source srcset="{{ asset("storage/eyeshots/$eyeshot->media") }}"
                    media="(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-device-pixel-ratio: 1.5), (min-resolution: 1.5dppx)">
                <source srcset="{{ asset("storage/eyeshots/$eyeshot->media") }}">
                <img class="img-fluid" alt="{{ $eyeshot->location_name }}"
                    src="{{ asset("storage/eyeshots/$eyeshot->media") }}">
            </picture>
        </a>
    </div>
    <div class="eyeshot-details slide-up">
        <p class="card-text eyeshot-location">{{ $eyeshot->location_name }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img class="eyeshot-avatar" src="{{ $eyeshot->owner->avatar }}">
                <p class="eyeshot-username">{{ $eyeshot->owner->name }}</p>
            </div>
            <small class="text-muted">{{ $eyeshot->created_at->diffForHumans() }}</small>
        </div>
    </div>
</div>
