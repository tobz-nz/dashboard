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
    import initAPNSPush from '../push/apn.js'

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
                console.log(registerResponse);

                if (!registerResponse) {
                    console.log('trying APN for push...');
                    initAPNSPush();
                }

                this.close();
            },
        }
    }
</script>
