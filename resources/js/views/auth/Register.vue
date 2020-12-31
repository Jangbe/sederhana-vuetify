<template>
 <v-form lazy-validation action="#" method="post" @submit.prevent="register">
    <p class="text-h4 text-center my-5">Register</p>
   <v-container>  
     <v-row no-gutters>
      <v-col md="7" cols="12" class="mx-auto">
      <v-text-field v-model="data.name" label="Nama" outlined :error-messages="hasErrors.name" @focus="hasErrors.name = ''" prepend-inner-icon="mdi-account"></v-text-field>
    
      <v-text-field v-model="data.email" label="E-Mail" outlined :error-messages="hasErrors.email" @focus="hasErrors.email = ''" type="email" prepend-inner-icon="mdi-email"></v-text-field> 

      <v-text-field v-model="data.telepon" label="Telepon" outlined :error-messages="hasErrors.telepon" @focus="hasErrors.telepon = ''" type="number" prepend-inner-icon="mdi-phone"></v-text-field>

      <v-text-field v-model="data.pass" label="Password" outlined :error-messages="hasErrors.pass" @focus="hasErrors.pass = ''" :type="show1? 'text':'password'" prepend-inner-icon="mdi-lock" :append-icon="show1?'mdi-eye':'mdi-eye-off'" @click:append="show1 = !show1"></v-text-field>

      <v-text-field v-model="data.confirm" label="Konfirmasi Password" outlined :error-messages="hasErrors.confirm" @focus="hasErrors.confirm = ''" :type="show2?'text':'password'" prepend-inner-icon="mdi-lock-check" :append-icon="show2?'mdi-eye':'mdi-eye-off'" @click:append="show2 = !show2"></v-text-field>
     
      <v-btn color="success" class="mr-4" type="submit"> Login </v-btn>
      </v-col>
     </v-row>
    
   </v-container>
  </v-form>
</template>

<script>
export default {
    data(){
        return {
            show1: false,
            show2: false,
            data: {
                name: '',
                email: '',
                telepon: '',
                pass: '',
                confirm: '',
            },
            hasErrors: {}
        }
    },
    methods: {
        async register(){
            try{
                let response = await axios.post('/api/auth/register', this.data);
                this.hasErrors = {};
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: response.data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                })
                this.$router.push('/belanja');
            }catch(e){
                this.hasErrors = e.response.data.errors;
            }
        },
    }
}
</script>

<style>

</style>
