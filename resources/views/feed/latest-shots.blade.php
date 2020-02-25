<div class="eyeshot-container-fluid">
    @if($eyeshots->isEmpty())
    <div class="eyeshots-not-found text-center mt-5">
        <h1>No eyeshots found!</h1>
        <a href="/" class="btn button-es btn-lg shadow m-2 font-weight-bold">Explore Something Awesome</a>
    </div>
    @else
    <div class="eyeshot-feed text-center py-4">
        <div class="row justify-content-center">
            @foreach ( $eyeshots as $eyeshot )
                @include('components/eyeshot')
            @endforeach
            @if( !isset($noPaginate) )
            {{ $eyeshots->links() }}
            @endif
        </div>
    </div>
    @endif
</div>