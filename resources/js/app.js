
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import Vue from 'vue';
import TfChart from './components/tf-chart.vue'

import initWebPush from './push/web.js'
import initAPNS from './push/apn.js'

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
});

[].slice.call(document.querySelectorAll('.sidebar-open, .sidebar-close'))
    .forEach(button => {
        button.addEventListener('click', event => {
            sidebar = document.querySelector('.sidebar').toggleAttribute('data-open')
        })
    });


/**
 * Boot up our service worker
 */

if ('serviceWorker' in navigator) {
    // Service worker to register for this site
    navigator.serviceWorker.register('/service-worker.js', {
        scope: '/',
    }).then((serviceWorkerRegistration) => {
        if (!initWebPush()) {
            console.log('trying APN for push...');
            initAPNS()
        }
    });
}
