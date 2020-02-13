@extends('layouts.app')

@section('content')

@include('feed/topbar')

<div class="eyeshot-container-fluid">
    <div class="eyeshot-feed text-center py-4">
        <div class="row justify-content-center">
            @foreach ( $eyeshots as $eyeshot )
                @include('components/eyeshot')
            @endforeach
        </div>
    </div>
</div>
@endsection
