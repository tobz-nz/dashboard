<template>
    <section v-if="active" @click="requestPermission" class="alert alert--info" role="dialog" aria-describedby="permission-description">
        <div id="permission-description">We need you permission <strong>enable push notifications</strong></div>
        <button class="close" @click.prevent="close">
            <svg width="15" height="15">
                <use xlink:href="/images/icons.svg#close"></use>
            </svg>
        </button>
    </section>
</template>

<script>
    import initWebPush from '../push/web.js'

    export default {
        components: {},

        props: {},

        data() {
            return {
                active: Notification.permission !== 'granted',
            }
        },

        computed: {},

        methods: {
            close() {
                this.active = false
            },

            async requestPermission(event) {
                console.log('trying for WebPush...');
                let registerResponse = await initWebPush();

                if (!registerResponse) {
                    console.log('trying APN for push...');

                    let permissionData = window.safari.pushNotification.permission(window.appData.apn.id);
                    if (permissionData.permission === 'default') {
                        // This is a new web service URL and its validity is unknown.

                        // Fetch user data, then ask for permission to send notifications
                        let userData = {
                            userId: String(appData.user.id)
                        }

                        window.safari.pushNotification.requestPermission(
                            route('apns').url(),     // The web service URL.
                            window.appData.apn.id,  // The Website Push ID.
                            userData,                // Data that you choose to send to your server to help you identify the user.
                            this.requestPermission   // The callback function.
                        );
                    }
                    else if (permissionData.permission === 'denied') {
                        // The user said no.
                        return false;
                    }
                    else if (permissionData.permission === 'granted') {
                        // The web service URL is a valid push provider, and the user said yes.
                        // permissionData.deviceToken is now available to use.
                        this.close();
                        return true;
                    }
                }
            },
        }
    }
</script>
