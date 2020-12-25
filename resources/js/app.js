
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import Vuetify from '../plugins/vuetify';
import App from './App.vue';

Vue.use(VueRouter);
Vue.use(Vuetify);

Vue.component('navbar', require('./components/Navbar.vue').default);

const app = new Vue({
    el: '#app',
    vuetify: Vuetify,
    render: h => h(App),
});
