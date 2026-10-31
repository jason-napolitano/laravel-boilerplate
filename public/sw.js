const CACHE_NAME = 'app-static-v1'

const OFFLINE_PAGE = '/offline.html'

const IMAGE_CACHE = 'app-images-v1'

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.add(OFFLINE_PAGE)
        }),
    )

    self.skipWaiting()
})

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key)))
        }),
    )

    self.clients.claim()
})

self.addEventListener('fetch', (event) => {
    const request = event.request

    if (request.method !== 'GET') {
        return
    }

    const url = new URL(request.url)

    if (url.origin !== self.location.origin) {
        return
    }

    /*
     * Handle navigation requests.
     */
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(() => {
                return caches.match(OFFLINE_PAGE)
            }),
        )

        return
    }

    /*
     * Cache static assets.
     */
    if (request.destination === 'script' || request.destination === 'style' || request.destination === 'font' || request.destination === 'image') {
        event.respondWith(
            caches.match(request).then((cachedResponse) => {
                if (cachedResponse) {
                    return cachedResponse
                }

                return fetch(request).then((response) => {
                    if (!response || response.status !== 200) {
                        return response
                    }

                    const responseClone = response.clone()

                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(request, responseClone)
                    })

                    return response
                })
            }),
        )
    }
})
