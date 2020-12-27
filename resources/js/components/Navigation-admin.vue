<template>
<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark shadow">
    <div class="container">
        <button class="navbar-toggler" id="menu-toggle">
            <span class="navbar-toggler-icon"></span>
        </button>

        <router-link class="navbar-brand " to="/"><img src="/img/icons/logo1.png" width="120" height="50"></router-link>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav toggled mr-auto">
                <li class="nav-item">
                    <router-link exact class="nav-link h6" :to="{name: 'admin'}"><i class="fas fa-inbox"></i> Pesanan</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link h6" to="/admin/struct"><i class="fas fa-sticky-note"></i> Buat Struct</router-link>
                </li>

                <!-- Dropdown -->
                <li class="nav-item">
                    <router-link class="nav-link h6" to="/belanja"><i class="fas fa-cart-plus"></i> Kategori</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link h6" to="/keranjang"><i class="fas fa-plus"></i> Tambah Barang</router-link>
                </li>
                    <li class="nav-item">
                        <router-link class="nav-link h6" to="/auth/signup"><i class="fas fa-edit"></i> Edit Barang</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link h6" to="/auth/signin"><i class="fas fa-plus-circle"></i> Tambah Stok </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link h6" to="/auth/profile"><i class="fas fa-user"></i> Profile</router-link>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link h6" @click="logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </li>
            </ul>
        </div>
    </div>
</nav>
</template>

<script>
    export default {
        props: ['auth'],
        data(){
            return{
            }
        },
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
