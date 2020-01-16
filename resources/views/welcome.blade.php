@extends('layouts.app')
@section('content')

@if (\Request::input('s'))
    @include('layouts/shared-eyeshot')
@else
    @include('layouts/landing')
@endif

@endsection