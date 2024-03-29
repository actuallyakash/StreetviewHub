<div class="eyeshot-container-fluid">
    @if($eyeshots->isEmpty())
    <div class="eyeshots-not-found text-center mt-5">
        <h1>No streetviews found!</h1>
        <a href="/" class="button-es btn btn-lg shadow m-2 font-weight-bold">Explore Something Awesome</a>
    </div>
    @else
    <div class="eyeshot-feed">
        @foreach ( $eyeshots as $eyeshot )
            @include('components/eyeshot')
        @endforeach
    </div>
    @endif
</div>