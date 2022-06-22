import { createApp } from 'vue'
import App from './App.vue'
import store from './store'
import axios from 'axios'

window.axios = axios

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

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
// Vue.component('v-app', require('./App.vue').default);
// Vue.component('v-login', require('./components/Login.vue').default);
// Vue.component('v-user', require('./components/User.vue').default);
// Vue.component('v-header', require('./components/Header.vue').default);
// Vue.component('v-statements', require('./components/Statements.vue').default);
// Vue.component('v-notice-window', require('./store/modules/popup/NoticeWindow.vue').default);
// Vue.component('v-tech', require('./components/Technical.vue').default);
// Vue.component('v-tech-info-window', require('./store/modules/popup/TechInfoWindow.vue').default);
// Vue.component('v-feed-back-window', require('./store/modules/popup/FeedBackWindow.vue').default);
// Vue.component('v-password-window', require('./store/modules/popup/passwordWindow.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

global.FILTERS = {
    get WORKED()   { return 1 << 2; },
    get FAULTY()   { return 1 << 1; },
};

global.sign = '#';

const app = createApp(App);
app.provide('api', function (method, data = {}, catchDefault = true) {
    let that = this;
    let token = localStorage.getItem('token');
    let url = 'api/';

    if (method === 'login' || method === 'mail/code/generate' || method === 'mail/code/success' || method === 'mail/code/registration') {
        url += method;
    } else {
        url += token + '/' + method;
    }

    let catchDefaultFunction = function (error) {
        switch (error.response.status) {
            case 401: { // Unauthorized
                that.$store.dispatch('auth/logout');
                break;
            }
        }
    };

    return new Promise(function (thenFunction, catchFunction) {
        axios.post(url, data).then(r => {
            thenFunction(r.data);
        }).catch(catchDefault ? catchDefaultFunction : catchFunction);
    });
});

const socket = {
    conn: null,

    handlers: new Map(),

    connect() {
        return new Promise((resolve, reject) => {
            this.conn = new WebSocket('ws://37.140.192.116:8080');

            this.conn.onopen = function (e) {
                console.log('Connection established!');
                resolve();
            };

            this.conn.onclose = function (e) {
                console.log('connection close');
                reject();
            };

            this.conn.onerror = function (e) {
                console.log('connection error');
            };

            this.conn.onmessage = (e) => {
                let data = JSON.parse(e.data);
                console.log('onMessage', data);
                if (this.handlers.has(data.message)) this.handlers.get(data.message)(data);
            };
        });
    },

    send(data) {
        this.conn.send(JSON.stringify(data));
    },

    on(name, handler) {
        this.handlers.set(name, handler);
    },
};

app.provide('socket', socket);

app.use(store);
app.mount('#app');
