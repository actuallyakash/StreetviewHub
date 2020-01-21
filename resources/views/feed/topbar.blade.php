<div class="top-bar">
  <nav class="topbar-action">
    <div class="sort-eyeshots">
        <select class="form-control">
            <option value="feed"{{ Request::url() == url('/feed') || Request::url() == url('/recent') ? ' selected' : '' }}><a href="/feed">Recent</a></option>
            <option value="popular"{{ Request::url() == url('/popular') ? ' selected' : '' }}><a href="/popular">Popular</a></option>
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