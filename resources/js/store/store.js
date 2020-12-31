import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
     state: {
         name: "devi",
         isLogin: false,
         user: {},
         links: [
            {icon: 'mdi-home', text: 'Home', route: '/'},
            {icon: 'mdi-cog', text: 'About', route: '/about'},
            {icon: 'mdi-cart-plus', text: 'Belanja', route: '/belanja'},
            {icon: 'mdi-cart-check', text: 'Checkout', route: '/keranjang'}
         ],
         carts: {
            count: 0,
            harga: 0,
            jumlah: 0,
            products: {}
         },
     },
     mutations: {
         changeName: (state, payload) => {
              state.name = payload;
         },
         login: (state, payload) => {
              state.links = payload;
              state.isLogin = true;
         },
         logout: (state, payload) => {
              state.links = payload;
              state.isLogin = false;
         },
         init: (state, payload) => {
              state.links = payload.links;
              state.isLogin = payload.isLogin;
         },
         editCart: (state, payload) => {
              state.carts = payload;
         },
     }

})