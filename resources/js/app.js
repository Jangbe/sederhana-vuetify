
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import Vuetify from '../plugins/vuetify';
import App from './App.vue';
import router from './router/index';
import Toasted from 'vue-toasted';
import {store} from './store/store';
import SweetAlert from 'vue-sweetalert2';

Vue.use(VueRouter);
Vue.use(Vuetify);
Vue.use(Toasted);
Vue.use(SweetAlert);

Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('cart', require('./components/Cart.vue').default);
Vue.component('kategori', require('./components/Category.vue').default);

const app = new Vue({
    el: '#app',
    vuetify: Vuetify,
    store,
    router: new VueRouter(router),
    render: h => h(App),
});
