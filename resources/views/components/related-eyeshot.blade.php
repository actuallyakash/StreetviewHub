<div class="eyeshot mb-4 shadow-sm">
    <div class="eyeshot-image">
        <div class="eyeshot-media">
            @if ( Request::input('id') == "true" )
            <span class="id-tag">{{ Helper::encode_id( $eyeshot->id ) }}</span>
            @endif
            <a href="{{ url('/') }}/{{ $eyeshot->owner->nickname }}/shot/{{ Helper::encode_id($eyeshot->id) }}">
                <picture>
                    <source srcset="{{ Storage::disk('s3')->url($eyeshot->media) }}" media="(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-device-pixel-ratio: 1.5), (min-resolution: 1.5dppx)">
                    <source srcset="{{ Storage::disk('s3')->url($eyeshot->media) }}">
                    <img class="img-fluid" alt="{{ $eyeshot->location_name }}" src="{{ Storage::disk('s3')->url($eyeshot->media) }}">
                </picture>
            </a>
        </div>
    </div>    
</div>
