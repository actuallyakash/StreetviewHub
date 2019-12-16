@extends('layouts.app')
@section('content')

<div class="explorer-profile">

   {{-- 
   # for future
   @include('profile/profile-cover') 
   --}}

   @include('profile/user-card')

   @include('profile/eyeshot-masonary')

</div>

@endsection