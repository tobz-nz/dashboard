export default function init() {
    console.log('register checks...');

    if (!('showNotification' in ServiceWorkerRegistration.prototype)) {
        console.log('Notifications aren\'t supported.')
        return
    }

    if (Notification.permission === 'denied') {
        console.log('The user has blocked notifications.')
        return
    }

    if (!('PushManager' in window)) {
        console.log('Push messaging isn\'t supported.')
        return
    }
    console.log('register checks complete');

    let updateSubscription = function(subscription) {
        const key = subscription.getKey('p256dh')
        const token = subscription.getKey('auth')
        const data = {
            endpoint: subscription.endpoint,
            key: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
            token: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null
        }

        // store the subscription server-side
        axios.post(route('api.notifications.subscribe'), data)
    }

    const urlB64ToUint8Array = base64String => {
        const padding = '='.repeat((4 - (base64String.length % 4)) % 4)
        const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/')
        const rawData = atob(base64)
        const outputArray = new Uint8Array(rawData.length)
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i)
        }
        return outputArray
    }

    navigator.serviceWorker.ready.then(registration => {
        registration.pushManager.getSubscription()
            .then(pushSubscription => {
                if (!pushSubscription) {

                    // fetch the VAPID public key
                    const publicPushKey = document.querySelector('meta[name=push-key]').content

                    registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: urlB64ToUint8Array(publicPushKey)
                    })
                    .then(pushSubscription => {
                        console.log('new pushSubscription registered', pushSubscription);
                        updateSubscription(pushSubscription)
                    })

                    return
                }

                // subscriptions get updated now and again,
                // so keep it updated here.
                updateSubscription(pushSubscription)
            })
            .catch(error => {
                console.log('Error during getSubscription()', error)
            })
        }).catch((error) => {
            console.log(`Service worker registration error: ${error}`);
    });
}
