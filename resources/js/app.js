/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
const VueGoogleMaps = require("vue2-google-maps");

Vue.use(VueGoogleMaps, {
    load: {
        key: process.env.MIX_MAPS_KEY,
        libraries: ["places", "geocoder"] // This is required if you use the Autocomplete plugin
    },
    installComponents: true
});

// Vue.use(VueRouter);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Vue.component("navbar", require("./components/NavBar.vue").default);
const lab = Vue.component("labs", require("./components/Labs.vue").default);
const map = Vue.component("maps", require("./components/Maps.vue").default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});
