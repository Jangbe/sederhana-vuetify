<template>
<nav>
    <v-app-bar app dark color="cyan">
        <v-app-bar-nav-icon @click="drawer = !drawer" class="d-flex d-md-none"></v-app-bar-nav-icon>
        <v-toolbar-title class="font-weight-bold">Sederhana Shop</v-toolbar-title>
        <v-spacer></v-spacer>
        <template v-for="(item, k) in links">
            <v-btn text :key="item.text" :to="item.route" class="d-none d-md-flex" v-if="isFinite(k)">
                <v-icon class="font-weight-bold" left v-text="item.icon"></v-icon>
                <strong v-text="item.text"></strong>
            </v-btn>
            <v-menu offset-y transition="slide-y-transition" :key="k" v-else>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn dark text v-bind="attrs" v-on="on" class="font-weight-bold d-none d-md-flex">
                    <v-icon left v-text="item[0]"></v-icon>
                    {{k}}
                    <v-icon right>mdi-menu-down</v-icon>
                    </v-btn>
                </template>

                <v-list>
                    <template v-for="(v, index) in item">
                        <v-list-item v-if="index != 0" :key="index" :to="v.route">
                            <v-list-item-title><v-icon left v-text="v.icon"></v-icon>{{ v.text }}</v-list-item-title>
                        </v-list-item>
                    </template>
                </v-list>
            </v-menu>
        </template>
       <template v-if="isLogin">
         <v-btn text to="/profile" class="d-none d-md-flex">
            <v-icon class="font-weight-bold" left>mdi-account</v-icon>
            <strong>Profile</strong>
        </v-btn>
        <v-btn text @click="logout" class="d-none d-md-flex">
            <v-icon class="font-weight-bold" left>mdi-logout</v-icon>
            <strong>Logout</strong>
        </v-btn>
       </template>
       <template v-else>
        <v-btn text to="/auth/signup" class="d-none d-md-flex">
            <v-icon class="font-weight-bold" left>mdi-account-plus</v-icon>
            <strong>Register</strong>
        </v-btn>
        <v-btn text to="/auth/signin" class="d-none d-md-flex">
            <v-icon class="font-weight-bold" left>mdi-login</v-icon>
            <strong>Login</strong>
        </v-btn>
       </template>
        <v-btn text @click="dcategory = !dcategory" class="d-flex d-md-none">
            <v-icon>mdi-shape</v-icon>
        </v-btn>
    </v-app-bar>

    <!-- Untuk drawer kategori -->
    <v-navigation-drawer temporary app right v-model="dcategory" color="cyan" dark>
        <v-list nav>
            <v-list-item>
                <v-list-item-icon>
                    <v-icon>mdi-shape</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Kategori</v-list-item-title>
            </v-list-item>
            <v-divider></v-divider>
            <v-list-item-group>
                <v-list-item :to="{name: 'product'}">
                    <v-list-item-title>Semua</v-list-item-title>
                </v-list-item>
                <v-list-item v-for="(categori, i) in categories" :to="{name: 'product', params: {category: categori.slug}}" :key="i">
                    <v-list-item-title v-text="categori.nama_kategori"></v-list-item-title>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-navigation-drawer>

    <!-- Untuk drawer menu -->
    <v-navigation-drawer temporary app v-model="drawer" dark>
        <v-list dense>
            <v-list-item two-line>
                <v-list-item-avatar>
                    <v-img src="/img/profile/default.jpg"></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title v-text="user.name"></v-list-item-title>
                    <v-list-item-subtitle>{{ isLogin? user.email : 'Not Logged In' }}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
        </v-list>
        <v-list nav dense>
            <v-list-item-group active-class="deep-purple--text text--accent-4" >
                <template v-for="(link, k) in links">
                    <v-list-item :key="link.text" v-if="isFinite(k)" :to="link.route">
                        <v-list-item-icon>
                        <v-icon v-text="link.icon"></v-icon>
                        </v-list-item-icon>
                        <v-list-item-title v-text="link.text"></v-list-item-title>
                    </v-list-item>
                    <v-list-group :key="k" v-else>
                        <template v-slot:activator>
                            <v-list-item-icon><v-icon v-text="link[0]"></v-icon></v-list-item-icon>
                            <v-list-item-title v-text="k"></v-list-item-title>
                        </template>
                        <template v-for="(item, k) in link">
                            <v-list-item v-if="k != 0" :key="k" :to="item.route">
                                <v-list-item-icon class="ml-4"><v-icon v-text="item.icon"></v-icon></v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title v-text="item.text"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                        <v-divider></v-divider>
                    </v-list-group>
                </template>
                <template v-if="isLogin">
                    <v-list-item to="/profile">
                        <v-list-item-icon>
                        <v-icon>mdi-account</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Profile</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="logout">
                        <v-list-item-icon>
                        <v-icon>mdi-logout</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item>
                </template>
                <template v-else>
                    <v-list-item to="/auth/signup">
                        <v-list-item-icon>
                        <v-icon>mdi-account-plus</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Register</v-list-item-title>
                    </v-list-item>
                    <v-list-item to="/auth/signin">
                        <v-list-item-icon>
                        <v-icon>mdi-login</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Login</v-list-item-title>
                    </v-list-item>
                </template>

            </v-list-item-group>
        </v-list>
    </v-navigation-drawer>
</nav>
</template>
<script>
export default{
    data(){
        return{
            drawer: false,
            dcategory: false,
            categories: [],
            lnks: []
        }
    },
    computed: {
        links(){
           return this.$store.state.links;
        },
        isLogin(){
           return this.$store.state.isLogin;
        },
        user(){
           return this.$store.state.user;
        },
    },
    mounted(){
        axios.get('/api/kategori/index').then(res => {
            this.categories = res.data;
        });
    },
    methods: {
            logout(){
                axios.get('/api/auth/logout').then(data => {
                  this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data.data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                  })
                });
                axios.get('/api/auth/init').then(res => {
                  this.$store.commit('logout', res.data.links);
                  this.$store.commit('userInit', res.data);
                });
                this.$router.push('/belanja');
            }
        }
}
</script>
