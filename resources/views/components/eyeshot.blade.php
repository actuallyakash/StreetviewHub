<div class="eyeshot mb-4 shadow-sm">
    <div class="eyeshot-image">
        <div class="eyeshot-media" data-user={{ $eyeshot->owner->nickname }} data-eyeshot="eyeshot-{{ Helper::encode_id($eyeshot->id) }}">
            @if ( $eyeshot->user_id == $eyeshot->pioneer )
            <span class="pioneer-tag"><i class="fas fa-medal"></i></span>
            @endif
            @if ( Request::input('id') == "true" )
            <span class="id-tag">{{ Helper::encode_id( $eyeshot->id ) }}</span>
            @endif
            <picture>
                <source srcset="{{ Storage::disk('s3')->url($eyeshot->media) }}" media="(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-device-pixel-ratio: 1.5), (min-resolution: 1.5dppx)">
                <source srcset="{{ Storage::disk('s3')->url($eyeshot->media) }}">
                <img class="img-fluid" alt="{{ $eyeshot->location_name }}" src="{{ Storage::disk('s3')->url($eyeshot->media) }}">
            </picture>
        </div>
    </div>
    <div class="eyeshot-details slide-up">
        <div class="d-flex justify-content-between align-items-center">
            <div class="eyeshot-meta">
                @if($eyeshot->title)
                <p title="{{ $eyeshot->title }}" class="eyeshot-status">{{ $eyeshot->title }}</p>
                @else
                <p title="Eyeshot by {{ ucfirst($eyeshot->owner->name) }}" class="card-text eyeshot-status">Eyeshot by <b>{{ ucfirst(explode(' ', $eyeshot->owner->name)[0]) }}</b></p>
                @endif
                <p class="eyeshot-published">{{ $eyeshot->created_at->diffForHumans() }}</p>
            </div>
            {{-- <button class="btn btn-outline-primary btn-sm"><i class="fas fa-heart"></i> Like</button> --}}
        </div>
    </div>
    
    @if( method_exists($eyeshots, 'links') )
        {{ $eyeshots->links() }}
    @endif
</div>
