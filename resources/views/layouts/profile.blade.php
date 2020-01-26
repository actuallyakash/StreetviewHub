@extends('layouts.app')
@section('content')

<div class="explorer-profile">

   {{-- 
   # for future
   @include('profile/profile-cover') 
   --}}

   @include('profile/user-card')

   <div class="eyeshot-container-fluid">
      <div class="eyeshot-feed text-center">
         <div class="row">
            @foreach ( $user->eyeshots as $eyeshot )
            <div class="col-md-4 col-sm-6">
               @include('components/eyeshot')
            </div>
            @endforeach
         </div>
      </div>
   </div>

</div>

@endsection