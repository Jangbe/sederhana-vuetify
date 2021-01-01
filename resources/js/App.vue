<template>
    <v-app app>
        <navbar/>
        <v-main>
            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>
export default{
    mounted(){
      this.init();
    },
    methods: {
       init(){
         axios.get('/api/auth/init').then(res => {
           this.$store.commit('init',
             {
               isLogin: res.data.isLogin,
               links: res.data.links
             }
           );
           this.$store.commit('userInit', res.data.user);
         });
         axios.get('/api/keranjang/get').then(data => {
            this.$store.commit('editCart', data.data);
         });
       }
    }
}
</script>
