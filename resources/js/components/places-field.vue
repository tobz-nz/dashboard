<template>
    <places
        v-model="address.name"
        placeholder="placeholder"
        @change="change"
        :options="{ type: 'address' }"
        ></places>
</template>

<script>
import Places from "vue-places";

export default {
    components: {
        Places
    },

    data() {
        return {
            address: {
                name: '',
                city: '',
                postcode: '',
                country: '',
                latlng: {
                    lat: 0,
                    lng: 0
                },
            }
        };
    },

    methods: {
        change(location) {
            this.$el.form['address-name'].value = location.name
            this.$el.form['address-city'].value = location.city
            this.$el.form['address-country'].value = location.country
            this.$el.form['address-postcode'].value = location.postcode
            this.$el.form['address-latlng-lat'].value = location.latlng.lat
            this.$el.form['address-latlng-lng'].value = location.latlng.lng
        }
    },
};
</script>

<style>
.algolia-places {
    width: auto;
}
</style>
