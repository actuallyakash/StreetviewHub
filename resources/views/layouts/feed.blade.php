@extends('layouts.app')

@section('content')

@include('feed/topbar')

<div class="container-fluid">
    <div class="eyeshot-feed text-center py-4">
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
