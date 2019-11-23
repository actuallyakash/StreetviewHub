@extends('layouts.app')
@section('content')
    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            @auth
            <a href="{{ url('/logout') }}">Logout</a>
            @else
            <a href="/">Login</a>
            @endauth
        </div>

        <div class="content">
            <div class="title m-b-md">
                StreetView
            </div>
            <h3>Get in</h3>
            <div class="links">
                <a href="/auth/google">Google</a>
                <a href="/auth/twitter">Twitter</a>
                <a href="/auth/github">Github</a>
            </div>
        </div>
    </div>
@endsection