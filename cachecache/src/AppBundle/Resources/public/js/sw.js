self.addEventListener('install', e => {
  e.waitUntil(
    caches.open('cachecache').then(cache => {
      return cache.addAll([
        '/',
        '/sw.js',
      ])
      .then(() => self.skipWaiting());
    })
  )
});
