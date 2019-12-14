<div class="top-bar">
  <nav class="topbar-action">
    <div class="sort-eyeshots">
        <select class="form-control">
            <option><a href="/recent">Recent</a></option>
            <option><a href="/popular">Popular</a></option>
            <option><a href="/saved">Most Saved</a></option>
        </select>
    </div>
    <div class="eyeshots-tags">
        Shots on 🔥 :
        @foreach ( Helper::trendingTags() as $tag )
          <a class="tag" href="/search?q={{ $tag->tags }}">{{ ucwords($tag->tags) }}</a>
        @endforeach
    </div>
  </nav>
</div>