// import { createApp } from 'vue';
import store from './store';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('v-app', require('./App.vue').default);
Vue.component('v-login', require('./components/Login.vue').default);
Vue.component('v-user', require('./components/User.vue').default);
Vue.component('v-header', require('./components/Header.vue').default);
Vue.component('v-statements', require('./components/Statements.vue').default);
Vue.component('v-notice-window', require('./store/modules/popup/NoticeWindow.vue').default);
Vue.component('v-tech', require('./components/Technical.vue').default);
Vue.component('v-tech-info-window', require('./store/modules/popup/TechInfoWindow.vue').default);
Vue.component('v-feed-back-window', require('./store/modules/popup/FeedBackWindow.vue').default);
Vue.component('v-password-window', require('./store/modules/popup/passwordWindow.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

global.FILTERS = {
    get WORKED()   { return 1 << 0; },
    get FAULTY()   { return 1 << 1; },
    get DISPOSED() { return 1 << 2; },
};

global.sign = '#';

const app = new Vue({
    el: '#app',
    store
});
