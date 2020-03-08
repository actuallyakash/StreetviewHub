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
         <div class="row justify-content-center">
            @php $eyeshots = $user->eyeshots; @endphp
            @foreach ( $eyeshots as $eyeshot )
               @include('components/eyeshot')
            @endforeach
         </div>
      </div>
   </div>

</div>

@endsection