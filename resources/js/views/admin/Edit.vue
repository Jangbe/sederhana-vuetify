<template>
  <v-container>
      <v-row v-if="!id_product">
          <div class="title col-12">Edit Barang</div>
          <v-col cols="12">
              <v-text-field v-model="search" @keyup="cari()" hide-details="" label="cari barang.."></v-text-field>
          </v-col>
          <v-col cols="12">
                <v-list>
                    <v-list-item-group>
                        <v-card>
                            <v-list-item class="cyan">
                                <v-list-item-content>
                                    <v-row class="white--text">
                                        <v-col cols="1">#</v-col>
                                        <v-col cols="3">Gambar</v-col>
                                        <v-col cols="4" md="3">Nama</v-col>
                                        <v-col cols="4" md="2">Opsi</v-col>
                                    </v-row>
                                </v-list-item-content>
                            </v-list-item>
                            <template v-for="(product, k) in products">
                                <v-divider :key="k+'d'"></v-divider>
                                <v-list-item :key="k" inactive>
                                    <v-list-item-content>
                                        <v-row no-gutters>
                                            <v-col cols="1" v-text="k+1"></v-col>
                                            <v-col cols="3"><v-img :src="`/img/barang/${product.gambar}`" width="80" alt="" :aspect-ratio="3/4"></v-img></v-col>
                                            <v-col cols="4" md="3">
                                                {{product.nama}}
                                                <v-subheader v-text="product.kategori"></v-subheader>
                                            </v-col>
                                            <v-col cols="4" md="2">
                                                <v-btn small text color="warning" :to="{name: 'admin.edit', params: {id_product: product.id}}"><v-icon left>mdi-square-edit-outline</v-icon>Edit</v-btn>
                                                <v-btn small text color="error"><v-icon left>mdi-delete</v-icon>Hapus</v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-list-item-content>
                                </v-list-item>
                            </template>
                        </v-card>
                    </v-list-item-group>
                </v-list>
          </v-col>
      </v-row>
      <v-row v-else>
          <v-col cols="12">
            <v-form action="#" method="post" role="form" @submit.prevent="add" lazy-validation>
            <v-card :loading="loading">
                <v-row no-gutters>
                    <v-col cols="12" md="4">
                        <v-img height="430" :src="`/img/barang/${input.oldGambar}`"></v-img>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-card-title>
                            <v-icon left>mdi-square-edit-outline</v-icon>
                            Edit Barang
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
                            <v-select outlined :items="categories" @focus="hasErrors.kategori = ''" :error-messages="hasErrors.kategori" @change="cek()" v-model="input.kategori" label="Kategori"></v-select>
                            <template v-for="(v, k) in category">
                                <v-text-field outlined type="number" min="0" v-if="k +1 != category.length" :key="k" v-model="input.detail[k]" :label="`1 ${v} berisi .. ${category[k+1]}`"></v-text-field>
                            </template>
                            <v-btn bottom color="primary" text type="submit">
                                <v-icon left>mdi-pen</v-icon>Edit Barang
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
    props: ['id_product'],
    data(){
        return{
            products: {},
            search: '',
            loading: false,
            hasErrors: {},
            categories: [],
            category: [],
            input: {
                id: '',
                nama: '',
                singkatan: '',
                gambar: {},
                harga: '',
                kategori: '',
                oldGambar: '',
                detail: []
            },
            rules: [
                value => !value || value.size < 3000000 || 'Ukuran gambar tidak boleh melebihi 3 MB!',
            ],
        }
    },
    mounted(){
        this.getProducts();
        this.show();
    },
    watch: {
        id_product: function(){
            this.show();
        }
    },
    methods: {
        getProducts(){
            axios.get('/api/product/index').then(data => {
                this.products = data.data.data;
            })
            axios.get('/api/kategori/index').then(data => {
                for(let v in data.data){
                    this.categories.push({text: data.data[v].nama_kategori, value: data.data[v].slug});
                }
            });
        },
        show(){
            if (this.id_product) {
                axios.get(`/api/product/index/${this.id_product}/show`).then(res => {
                    var input = res.data.data;
                    this.input.id = input.id;
                    this.input.nama = input.nama;
                    this.input.singkatan = input.singkatan;
                    this.input.harga = input.harga;
                    this.input.kategori = {text: input.kategori, value: input.slug};
                    this.input.oldGambar = input.gambar;
                    this.cek(input.slug, input.detail.split('-'));
                })
            }
        },
        cari(){
            if(this.search){
                axios.get(`/api/product/search/all/${this.search}`).then(data => {
                    this.products = data.data.data;
                })
            }else{
                this.getProducts();
            }
        },
        cek(v = null, k = null){
            var kategori = v == null? this.input.kategori : v;
            axios.get(`/api/kategori/show/${kategori}`).then(data => {
                this.input.detail = [];
                this.category = data.data.detail;
                if(k != null) this.input.detail = k;
            })
        },
        add(){
            this.input.detail[this.category.length-1] = 1;
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

            axios.post('/api/admin/edit-product', data, config).then(res => {
                console.log(res.data);
                this.$swal.fire({
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-end',
                    icon: res.data.type,
                    title: res.data.message,
                    timer: 3000,
                    timerProgressBar: true
                })
            }).catch(e => {
                this.hasErrors = e.response.data.errors
            })
        }
    }
}
</script>

<style>

</style>
