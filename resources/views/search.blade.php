@extends('layouts.app')
@php
    $searchTerm = Request::input('q');
@endphp
@section('content')

@section('title', "$searchTerm - Search | Eyeshot ")

@include('feed/topbar')

<div class="eyeshot-container-fluid">
    <div class="eyeshot-feed text-center py-4">
        <h3 class="mb-4 text-muted">{{ count($eyeshots) }} result{{ count($eyeshots) == 1 ? '' : 's' }} for <strong class="text-dark">{{ $searchTerm }}</strong></h3>
        <div class="row">

            @foreach ( $eyeshots as $eyeshot )
                <div class="col-md-4 col-sm-6">
                    @include('components/eyeshot')
                </div>
            @endforeach

            
        </div>

    </div>
</div>
@endsection
