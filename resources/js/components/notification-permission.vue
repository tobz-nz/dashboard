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
                active: true,
            }
        },

        computed: {},

        methods: {
            close() {
                this.active = false
            },

            async requestPermission(event) {
                console.log(event);
                let asd = await initWebPush()
                console.log(asd);
                if (!asd) {
                    console.log('trying APN for push...');
                    if (!initAPNSPush()) {
                        this.close();
                    }
                }
            },
        }
    }
</script>
