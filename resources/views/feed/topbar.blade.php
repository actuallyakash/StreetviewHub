<div class="top-bar">
  <nav class="topbar-action">
    <div class="sort-eyeshots">
        <select class="form-control">
            <option><a href="/recent">Recent</a></option>
            <option><a href="/popular">Popular</a></option>
            <option><a href="/saved">Most Saved</a></option>
        </select>
    </div>
    <div class="eyeshot-tags">
        <span title="Trending Tags">🔥</span>
        @foreach ( Helper::trendingTags() as $tag )
          <a class="eyeshot-tag badge" href="/search?q={{ $tag->tags }}">{{ ucwords($tag->tags) }}</a>
        @endforeach
        <span title="Trending Tags">🔥</span>
    </div>
  </nav>
</div>