import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
     state: {
         name: "devi",
         isLogin: false,
         isAdmin: true,
         user: {},
         links: {},
         carts: {
            count: 0,
            harga: 0,
            jumlah: 0,
            products: {}
         },
     },
     mutations: {
         userInit: (state, payload) => {
              state.user = payload.user;
              state.isAdmin = payload.isAdmin;
         },
         changeName: (state, payload) => {
              state.name = payload;
         },
         login: (state, payload) => {
              state.links = payload.links;
              state.isAdmin = payload.isAdmin;
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
