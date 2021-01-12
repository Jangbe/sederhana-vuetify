<template>
<v-container>
    <v-dialog v-model="dialog" persistent max-width="650px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="success" dark v-bind="attrs" v-on="on">
          Tambah Kategori
        </v-btn>
      </template>
      <v-form methods="post" action="#" @submit.prevent="add()">
      <v-card>
        <v-card-title>
          <span class="headline">Tambah Kategori</span>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-container>
            <v-row>
             <v-text-field outlined type="text" v-model="form.nama" label="Nama Kategori" :error-messages="hasErrors.nama" @focus="hasErrors.nama = ''"></v-text-field>
             <v-text-field outlined type="number" min="1" v-model="form.jumlah" label="Detail Kategori" @keyup="detail()" @change="detail()" :error-messages="hasErrors.jumlah" @focus="hasErrors.jumlah = ''"></v-text-field>
             <v-text-field outlined v-for="(i, k) in form.detail"
                :key="k"
                :label="`Detail ke-${k+1}`"
                type="text" v-model="form.detail[k]" :rules="rules">
                 
             </v-text-field>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="error" text @click="dialog = false">Close</v-btn>
          <v-btn color="success" text type="submit">Save</v-btn>
        </v-card-actions>
      </v-card>
      </v-form>
    </v-dialog>
<v-row>
   
</v-row>
</v-container>
</template>

<script>
import Cart from '../../components/Cart.vue';
import number_format from '../../number_format';
export default {
    data(){
        return {
            number_format,
            dialog: false,
            form: {
                nama: '',
                jumlah: 1,
                detail: [''],
            },
            hasErrors: {},
            rules: [
                v => !!v || 'Detail is required'
            ],
        }
    },
    mounted(){
        this.number_format = number_format;
    },
    methods: {
        detail(){
            let a = this.form.jumlah;
            this.form.detail = ['']
            for(let i = 1; i < a; i++){
                this.form.detail[i] = ''
            }
        },
        async add(){
            try{
                var response = await axios.post('/api/admin/category', this.form)
            }catch(e){
                this.hasErrors = e.response.data.errors;
            }
            
        }
    }
}
</script>

<style>

</style>
