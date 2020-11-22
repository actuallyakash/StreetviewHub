<div class="container">
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
    
    {{-- Related Posts --}}
    @isset($eyeshot)
        @php $relatedEyeshots = Helper::getRelatedPosts( $eyeshot->id, explode( ',', $eyeshot->tags ), 3 ); @endphp
        @if ( count( $relatedEyeshots ) > 0 )
            <h4 class="text-center my-4">Related Streetviews</h4>
            <div class="related-posts my-4">
                @foreach ( $relatedEyeshots as $eyeshot )

                    @include('components/related-eyeshot')

                @endforeach
            </div>
        @endif
    @endisset
    
    <div id="disqus_thread"></div>
</div>