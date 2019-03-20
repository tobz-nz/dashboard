
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import Vue from 'vue';
import TfChart from './components/tf-chart.vue'

function randomData() {
    now = new Date(+now + oneDay);
    value = value + Math.random() * 21 - 10;
    return {
        name: now.toString(),
        value: [
            [now.getFullYear(), now.getMonth() + 1, now.getDate()].join('/'),
            Math.round(value)
        ]
    }
}
window.data = [];
var now = +new Date(1997, 9, 3);
var oneDay = 24 * 3600 * 1000;
var value = Math.random() * 1000;
for (var i = 0; i < 1000; i++) {
    data.push(randomData());
}

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(TfChart)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

document.addEventListener('click', event => {
    // clicking off an open details.autoclose, closes it
    if (!event.target.closest('details')) {
        document.querySelectorAll('details.autoclose[open]').forEach(el => {
            el.removeAttribute('open')
        })
    }
})


/**
 * Boot up our service worker
 */

if ('serviceWorker' in navigator) {
    // Service worker to register for this site
    navigator.serviceWorker.register('/service-worker.js', {
        scope: '/',
    }).then((serviceWorkerRegistration) => {
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
    });
}
