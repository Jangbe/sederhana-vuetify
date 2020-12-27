<template>
<!-- Sidebar -->
<div class="list-group-item-dark d-md-none" id="sidebar-wrapper">
    <div class="sidebar-heading">Sederhana </div>
    <div class="list-group list-group-flush">
        <router-link :to="{name: 'admin'}" exact class="list-group-item list-group-item-action js-scroll-trigger list-group-item-dark"><i class="fas fa-inbox"></i> Pesanan</router-link>
        <router-link to="/admin/struct" class="list-group-item list-group-item-action js-scroll-trigger list-group-item-dark"><i class="fas fa-sticky-note"></i> Struct</router-link>
        <!-- Dropdown -->
        <router-link to="/belanja" class="list-group-item list-group-item-action js-scroll-trigger list-group-item-dark"><i class="fas fa-cart-plus"></i> Kategori</router-link>
        <router-link to="/keranjang" class="list-group-item list-group-item-action js-scroll-trigger list-group-item-dark"><i class="fas fa-plus"></i> Tambah Barang</router-link>
            <router-link to="/auth/signup" class="list-group-item list-group-item-action js-scroll-trigger list-group-item-dark"><i class="fas fa-user-plus"></i> Edit Barang</router-link>
            <router-link to="/auth/signin" class="list-group-item list-group-item-action js-scroll-trigger list-group-item-dark"><i class="fas fa-sign-in-alt"></i> Tambah Stok</router-link>
            <router-link to="/auth/signup" class="list-group-item list-group-item-action js-scroll-trigger list-group-item-dark"><i class="fas fa-user-plus"></i> Profile</router-link>
            <button @click="logout" class="list-group-item list-group-item-action js-scroll-trigger list-group-item-dark"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </div>
</div>
<!-- /#sidebar-wrapper -->
</template>

<script>
export default {
    props: ['auth'],
    methods: {
        logout(){
            axios.get('/api/auth/logout').then(data => {
                this.$toasted.show(data.data.message, {
                    duration: 2000,
                    type: 'success'
                });
            });
            this.auth.isLogin = false;
            this.auth.isAdmin = false;
            this.auth.user = {};
            this.$router.push('/belanja');
        }
    }
}
</script>

<style>

</style>
