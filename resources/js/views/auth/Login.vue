<template>
  <v-form lazy-validation action="#" method="post" @submit.prevent="login">
    <p class="text-h4 text-center my-5">Login</p>
   <v-container>
     <v-row no-gutters>
      <v-col md="7" cols="12" class="mx-auto">
      <v-text-field v-model="data.email" label="E-Mail" outlined :error-messages="hasErrors.email" @focus="hasErrors.email = ''" type="email" prepend-inner-icon="mdi-email"></v-text-field>

      <v-text-field v-model="data.password" label="Password" outlined :error-messages="hasErrors.password" @focus="hasErrors.password = ''" :type="show? 'text' : 'password'" prepend-inner-icon="mdi-lock" :append-icon="show? 'mdi-eye' : 'mdi-eye-off'" @click:append="show = !show"></v-text-field>

      <v-checkbox v-model="data.remember" label="Remember me?" outlined ></v-checkbox>

      <v-btn color="success" class="mr-4" type="submit"> Login </v-btn>
    </v-col>
    </v-row>
   </v-container>
  </v-form>
</template>

<script>
export default {
    data(){
        return{
            show: false,
            data: {
                email: '',
                password: '',
                remember: null,
            },
            hasErrors: {}
        }
    },
    methods: {
        async login(){
            try{
                var response = await axios.post('/api/auth/login', this.data);
                this.hasErrors = {};
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: response.data.type,
                    title: response.data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                })
                if (response.data.type == 'success') {
                    axios.get('/api/auth/init').then(res => {
                        this.$store.commit('login', res.data);
                        this.$store.commit('userInit', res.data);
                        res.data.isAdmin? this.$router.push('/admin/pesanan') : this.$router.push('/belanja');
                    });
                }
            }catch(e){
                this.hasErrors = e.response.data.errors;
            }
        },
    }
}
</script>

<style>

</style>
