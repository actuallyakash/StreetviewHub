<div class="container">
    <div class="eyeshots-mason">
        <div class="masonry">
            
            @foreach ($user->eyeshots as $eyeshot)
            <div class="eyeshot-mason">
                @include('components/eyeshot')
            </div>
            @endforeach
            
        </div>
    </div>
</div>