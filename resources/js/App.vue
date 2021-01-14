<template>
    <v-app app>
        <navbar/>
        <v-main>
            <router-view></router-view>
        </v-main>
        <v-footer>
            <v-container class="my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Sederhana Shop 2021</span>
                </div>
            </v-container>
        </v-footer>
    </v-app>
</template>

<script>
export default{
    beforeCreate(){
        axios.get('/api/keranjang/get').then(data => {
            this.$store.commit('editCart', data.data);
        });
        axios.get('/api/kategori/index').then(data => {
            this.$store.commit('category', data.data);
        });
        axios.get('/api/auth/init').then(res => {
            this.$store.commit('userInit', res.data);
            this.$store.commit('init',{
                isLogin: res.data.isLogin,
                links: res.data.links
            });
            var admin = this.$route.path.split('/')[1] != 'admin'
            if(res.data.isAdmin && admin){
                this.$router.push('/admin/pesanan');
            }
        });
    }
}
</script>
