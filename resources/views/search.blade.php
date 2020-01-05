@extends('layouts.app')
@php
    $searchTerm = Request::input('q');
@endphp
@section('content')

@section('title', "$searchTerm - Search | Eyeshot ")

@include('feed/topbar')

<div class="container-fluid">
    <div class="eyeshot-feed text-center py-4">
        <h3>{{ count($eyeshots) }} result{{ count($eyeshots) == 1 ? '' : 's' }} for {{ $searchTerm }}</h3>
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