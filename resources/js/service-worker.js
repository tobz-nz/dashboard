var CACHE = 'v1';

/* Cache files for offline use */
self.addEventListener('install', event => {
    console.log('SW installed', event);

    // Open a cache store called `v1`
    event.waitUntil(
        caches.open(CACHE).then(cache => {
            // Cache all these files
            return cache.addAll([
                '/offline',
            ]);
        })
    );
});


self.addEventListener('activate', event => {
    console.log('SW activated');

    /* Cache */
    var cacheWhitelist = [CACHE];
    event.waitUntil(
        caches.keys().then(keyList => {
            return Promise.all(keyList.map(key => {
                if (cacheWhitelist.indexOf(key) === -1) {
                    return caches.delete(key);
                }
            }));
        })
    )
});


/* Fetch offline files */
// self.addEventListener('fetch', event => {
//     // console.log('SW fetching...', event.request.url);

//     function fromNetwork(request, timeout) {
//         return new Promise((fulfill, reject) => {
//             var timeoutId = setTimeout(reject, timeout);

//             fetch(request).then(response => {
//                 clearTimeout(timeoutId);
//                 fulfill(response);
//             }, reject)
//         });
//     };

//     function fromCache(request) {
//         return caches.open(CACHE).then(cache => {
//             return cache.match(request).then(matching => {
//                 return matching || Promise.reject('no-match');
//             });
//         });
//     };

//     function update(request) {
//         return caches.open(CACHE).then(cache => {
//             return fetch(request).then(response => {
//                 return cache.put(request, response);
//             });
//         });
//     };

//     event.respondWith(
//         fromNetwork(event.request, 400)
//             .catch(() => {
//                 return fromCache(event.request);
//             })
//     );
// });



/* Forward push notifications */
self.addEventListener('push', event => {
    console.log('Push Received');

    if (event && event.data) {
        const data = event.data.json();

        console.log(data);

        event.waitUntil(
            self.registration.showNotification(data.title, {
                body: data.body,
                icon: data.icon || null,
                image: data.image || null,
                data: data.data || null
            })
        )
    }
});

self.addEventListener('notificationclick', event => {
    console.log(event.notification.data);

    event.notification.close();

    // This looks to see if the site is already open in a tab
    // and focuses if it is, else open it in a new tab.
    event.waitUntil(
        clients.matchAll({ type: "window", includeUncontrolled: true }).then(clientList => {
            for (var i = 0; i < clientList.length; i++) {
                if ('focus' in clientList[i]) {
                    // focus the existing window/tab
                    clientList[i].focus();
                    if (clientList[i].url != event.notification.data.url) {
                        console.log('urls not matching', clientList[i].url, event.notification.data.url);
                        // navigate to the notifications provided url
                        clientList[i].navigate(event.notification.data.url)
                    }

                    return
                }
            }

            if (!clientList.length) {
                if (clients.openWindow) {
                    // no windows/tabs open, so open a new one
                    return clients.openWindow('/');
                }
            }
        })
    );
})

self.addEventListener('pushsubscriptionchange', function(event) {
    console.log('Subscription expired');

    event.waitUntil(
        self.registration.pushManager
        .subscribe({ userVisibleOnly: true })
        .then(subscription => {

            console.log('Subscribed after expiration', subscription.endpoint);

            return fetch('/api/push-service', {
                method: 'post',
                headers: {
                    'Content-type': 'application/json'
                },
                body: JSON.stringify({
                    endpoint: subscription.endpoint
                })
            });
        })
    );
});
