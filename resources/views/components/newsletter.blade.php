<div class="container">
    <div id="newsletter" class="newsletter nsource-{{ $source ?? 'footer' }} m-5 p-5 d-flex align-items-center justify-content-center justify-content-xl-between flex-wrap text-center text-xl-left">
        <div class="newsletter-content">
            <h2>Each week I share new eyeshots <br>in the Newsletter.</h2>
            <p class="sub-text text-white-50"> With beautiful, cool and awesome locations. I'd love you to join. </p>
        </div>
        <div class="newsletter-cta d-flex flex-wrap flex-md-nowrap">
            <input name="source" type="hidden" value="{{ URL::current() }}?el={{ isset( $source ) ? $source : "footer" }}">
            <input class="email" name="email" type="email" placeholder="Your email" autocomplete="off">
            <button type="submit" data-source="{{ $source ?? 'footer' }}" class="btn btn-large ml-md-3 col-md-4 col-12 col-form-lable-lg font-weight-bolder subscribe-btn">Try it out</button>
        </div>
    </div>
</div>