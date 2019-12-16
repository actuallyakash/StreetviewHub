<div class="container">
    <div class="eyeshots-mason">
        <div class="masonry">
            
            @foreach ($user->eyeshots as $eyeshot)
            <div class="eyeshot-mason">
                <img src="{{ asset("storage/eyeshots/$eyeshot->media") }}" alt="{{ $eyeshot->location_name }}" class="eyeshot-media">
            </div>
            @endforeach
            
        </div>
    </div>
</div>