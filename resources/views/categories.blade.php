@extends('layouts.app')
@section('content')

@section('title', "Categories | StreetviewHub")

@include('feed/topbar')

<div class="container p-5">

    <div class="categories-index">
        @foreach ( array_keys($filteredCats) as $index )
        <a href="#{{ $index }}">{{ $index }}</a>
        @endforeach
    </div>
    
    <div class="row">
        @foreach ($filteredCats as $key => $category)
            <div class="col-md-4 col-sm-6 col-6">
                <h3 id="{{ $key }}">{{ ucfirst($key) }}</h3>
                <ul>
                @foreach ($category as $cat)
                    <li><a href="/search/?q={{ ($key == "other") ? $cat['title'] : strtolower($cat['title']) }}">{{ ($key == "other") ? $cat['title'] : ucfirst($cat['title']) }} ({{ $cat['total'] }})</a></li>
                @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>

@include('components.newsletter')

@endsection
