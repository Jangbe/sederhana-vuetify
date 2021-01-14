<template>
  <v-container class="mt-2">
      <v-row>
            <v-col cols="12">
                <v-form action="#" method="post" role="form" @submit.prevent="add" lazy-validation>
                <v-card :loading="loading">
                    <v-row no-gutters>
                        <v-col cols="12" md="4">
                            <v-img height="430" :src="`/img/barang/default.jpg`"></v-img>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-card-title>
                                <v-icon left>mdi-briefcase-plus</v-icon>
                                Tambah Barang
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-card-text>
                                <v-text-field outlined @focus="hasErrors.nama = ''" :error-messages="hasErrors.nama" label="Nama Barang" v-model="input.nama"></v-text-field>
                                <v-text-field outlined @focus="hasErrors.singkatan = ''" :error-messages="hasErrors.singkatan" label="Singkatan Barang" v-model="input.singkatan"></v-text-field>
                                <v-text-field outlined @focus="hasErrors.harga = ''" :error-messages="hasErrors.harga" prefix="Rp." label="Harga Barang" type="number" min="0" v-model="input.harga"></v-text-field>
                                <v-file-input outlined @focus="hasErrors.gambar = ''" :error-messages="hasErrors.gambar" id="file" :rules="rules" prepend-inner-icon="mdi-camera" prepend-icon="" counter show-size accept="image/png, image/jpeg" label="Gambar Barang" v-model="input.gambar"></v-file-input>
                            </v-card-text>
                            <v-divider class="d-flex d-md-none"></v-divider>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-card-title>
                                <v-icon left>mdi-shape</v-icon>
                                Kategori
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-card-text>
                                <v-select outlined :items="categories" @focus="hasErrors.kategori = ''" :error-messages="hasErrors.kategori" @change="cek" v-model="input.kategori" label="Kategori"></v-select>
                                <template v-for="(v, k) in category">
                                    <v-text-field outlined type="number" min="0" v-if="k +1 != category.length" :key="k" v-model="input.detail[k]" :label="`1 ${v} berisi .. ${category[k+1]}`"></v-text-field>
                                </template>
                                <v-btn bottom color="primary" text type="submit">
                                    <v-icon left>mdi-plus-circle</v-icon>Tambahkan Barang
                                </v-btn>
                            </v-card-text>
                        </v-col>
                    </v-row>
                </v-card>
                </v-form>
            </v-col>
        </v-row>
  </v-container>
</template>

<script>
export default {
    data(){
        return{
            input: {
                nama: '',
                singkatan: '',
                gambar: {},
                harga: '',
                kategori: '',
                detail: []
            },
            hasErrors: {},
            loading: false,
            categories: [],
            category: [],
            rules: [
                value => !value || value.size < 3000000 || 'Ukuran gambar tidak boleh melebihi 3 MB!',
            ],
        }
    },
    beforeCreate(){
        axios.get('/api/auth/init').then(data => {
            if(!data.data.isAdmin){
                this.$router.push('/auth/signin');
            }
        })
    },
    mounted(){
        this.init();
    },
    methods: {
        init(){
            axios.get('/api/kategori/index').then(data => {
                for(let v in data.data){
                    this.categories.push({text: data.data[v].nama_kategori, value: data.data[v].slug});
                }
            });
        },
        cek(){
            axios.get(`/api/kategori/show/${this.input.kategori}`).then(data => {
                this.input.detail = [];
                this.category = data.data.detail;
            })
        },
        async add(){
            this.input.detail[this.category.length-1] = 1;
            try{
                var data = new FormData();
                data.append('nama', this.input.nama);
                data.append('singkatan', this.input.singkatan);
                data.append('harga', this.input.harga);
                data.append('kategori', this.input.kategori);
                data.append('detail', this.input.detail);
                data.append('gambar', this.input.gambar);

                var config = {
                    headers: {'content-type': 'multipart/form-data'}
                }

                let res = await axios.post('/api/admin/product', data, config);
                this.$swal.fire({
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-end',
                    icon: res.data.type,
                    title: res.data.message,
                    timer: 3000,
                    timerProgressBar: true
                });
            }catch(e){this.hasErrors = e.response.data.errors}
        }
    }
}
</script>

<style>

</style>
