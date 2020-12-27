<template>
<nav>
    <v-app-bar app dark color="cyan">
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title>Sederhana Shop</v-toolbar-title>
        <v-spacer></v-spacer>
            <v-btn text>
                <span>Logout</span>
                <v-icon right>mdi-logout</v-icon>
            </v-btn>
    </v-app-bar>
    <v-navigation-drawer temporary app v-model="drawer" dark>
        <v-list dense>
            <v-list-item two-line>
                <v-list-item-avatar>
                    <v-img src="/img/profile/default.jpg"></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title>Unknow</v-list-item-title>
                    <v-list-item-subtitle>No Logged In</v-list-item-subtitle>
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
            </v-list-item-group>
        </v-list>
    </v-navigation-drawer>
</nav>
</template>
<script>
export default{
    props: ['auth'],
    data(){
        return{
            drawer: false,
            links: []
        }
    },
    mounted(){
        axios.get('/api/auth/init').then(res => {
            this.links = res.data.links;
        });
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
