
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import Vue from 'vue';


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

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

            axios.post(route('api.notifications.subscribe'), data).then(response => {
                // console.log(response);
            })
        }

        navigator.serviceWorker.ready.then(registration => {
            registration.pushManager.getSubscription()
                .then(pushSubscription => {

                    if (!pushSubscription) {
                        registration.pushManager.subscribe().then(pushSubscription => {
                            console.log('new pushSubscription registered', pushSubscription);
                            updateSubscription(pushSubscription)
                        })

                        return
                    }

                    // console.log('existing pushSubscription', pushSubscription)
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
