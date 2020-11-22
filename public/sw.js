var CACHE_NAME = 'streetviewhub-pwa-v1';
self.addEventListener('install', async function () {
    const cache = await caches.open(CACHE_NAME);
    cache.addAll([
        '/offline.html',
    ])
});

self.addEventListener('fetch', function (event) {});