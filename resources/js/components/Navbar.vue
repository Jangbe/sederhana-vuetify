<template>
<nav>
    <v-app-bar app dark color="cyan">
        <v-app-bar-nav-icon @click="drawer = !drawer" class="d-flex d-md-none"></v-app-bar-nav-icon>
        <v-toolbar-title class="font-weight-bold">Sederhana Shop</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn text v-for="link in links" :key="link.text" :to="link.route" class="d-none d-md-flex">
            <v-icon class="font-weight-bold" left v-text="link.icon"></v-icon>
            <strong v-text="link.text"></strong>
        </v-btn>
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
        <v-btn text @click="drawer = !drawer" class="d-flex d-md-none">
            <v-icon>mdi-shape</v-icon>
        </v-btn>
    </v-app-bar>
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
                <v-list-item v-for="link in links" :key="link.text" :to="link.route">
                    <v-list-item-icon>
                    <v-icon v-text="link.icon"></v-icon>
                    </v-list-item-icon>
                    <v-list-item-title v-text="link.text"></v-list-item-title>
                </v-list-item>
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
        }
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
                  this.$store.commit('userInit', res.data.user);
                });
                this.$router.push('/belanja');
            }
        }
}
</script>
