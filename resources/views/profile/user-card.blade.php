<div class="card user-profile-card p-3" style="width: 18rem;">
  <img src="{{ $user->avatar }}" style="height: 150px; width: 150px;" class="rounded-circle" alt="{{ $user->nickname }}">
  <div class="card-body">
    <h5 class="card-title">{{ $user->nickname }}</h5>
    <p class="card-text">{{ $user->bio }}</p>
  </div>
</div>