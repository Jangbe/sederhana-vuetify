<template>
  <v-container>
      <not-found v-if="notFound"></not-found>
      <stok-loader v-else-if="first && load"></stok-loader>
      <template v-else-if="first">
          <v-row>
              <v-col cols="12" class="mt-2">
                  <v-skeleton-loader class="title" width="300" type="heading"></v-skeleton-loader>
              </v-col>
              <v-col cols="7" md="9" class="mt-7">
                  <v-skeleton-loader type="text"></v-skeleton-loader>
              </v-col>
              <v-col cols="5" md="3" class="mt-7">
                  <v-skeleton-loader type="text"></v-skeleton-loader>
              </v-col>
              <v-col cols="12" class="mt-2">
                  <v-card>
                      <v-skeleton-loader type="table-thead"></v-skeleton-loader>
                      <v-divider></v-divider>
                      <v-skeleton-loader type="table-tbody@2"></v-skeleton-loader>
                  </v-card>
              </v-col>
          </v-row>
      </template>
      <template v-else>
      <v-row v-if="!id_product">
          <div class="title col-12">Edit Barang</div>
          <v-col cols="7" md="9">
              <v-text-field v-model="search" @keyup="cari()" hide-details="" label="cari barang.."></v-text-field>
          </v-col>
          <v-col cols="5" md="3">
            <v-select :items="kategori2" @change="getProducts" v-model="kategori" hide-details="" label="Sort Kategori"></v-select>
          </v-col>
          <v-col cols="12">
                <v-list>
                    <v-list-item-group>
                        <v-card>
                            <v-list-item class="cyan">
                                <v-list-item-content>
                                    <v-row class="white--text">
                                        <v-col cols="1">#</v-col>
                                        <v-col cols="3" md="2">Gambar</v-col>
                                        <v-col cols="5" md="7">Nama</v-col>
                                        <v-col cols="3" md="2">Opsi</v-col>
                                    </v-row>
                                </v-list-item-content>
                            </v-list-item>
                            <template v-for="(product, k) in products">
                                <v-divider :key="k+'d'"></v-divider>
                                <v-list-item :key="k" inactive>
                                    <v-list-item-content>
                                        <v-row no-gutters>
                                            <v-col cols="1" v-text="k+1"></v-col>
                                            <v-col cols="3" md="2">
                                                <v-card width="80">
                                                    <v-img :src="product.link" width="80" alt="" :aspect-ratio="3/4" class="white--text align-end" gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"></v-img>
                                                </v-card>
                                            </v-col>
                                            <v-col cols="5" md="7" class="pl-2">
                                                {{product.nama}}
                                                <v-subheader v-text="product.kategori"></v-subheader>
                                            </v-col>
                                            <v-col cols="3" md="2">
                                                <v-btn small text color="warning" :to="{name: 'admin.edit', params: {id_product: product.id}}"><v-icon left>mdi-square-edit-outline</v-icon>Edit</v-btn>
                                                <v-btn small text color="error" @click="hapus(product.id)"><v-icon left>mdi-delete</v-icon>Hapus</v-btn>
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
            <stok-loader v-if="load"></stok-loader>
            <v-form v-else action="#" method="post" role="form" @submit.prevent="add" lazy-validation>
            <v-card :loading="loading">
                <v-row no-gutters>
                    <v-col cols="12" md="4">
                        <v-img height="430" :src="input.oldGambar"></v-img>
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
                            <v-btn bottom color="primary" text type="submit" :disabled="loading">
                                <v-progress-circular color="primary" indeterminate v-if="loading"></v-progress-circular>
                                <span v-else><v-icon left>mdi-pen</v-icon>Edit Barang</span>
                            </v-btn>
                        </v-card-text>
                    </v-col>
                </v-row>
            </v-card>
            </v-form>
        </v-col>
      </v-row>
      </template>
  </v-container>
</template>

<script>
import notFound from './../404.vue';
import StokLoader from './StokLoader.vue';
export default {
    components: {'not-found': notFound, 'stok-loader': StokLoader},
    props: ['id_product'],
    data(){
        return{
            first: true,
            products: {},
            product: {},
            search: '',
            loading: false,
            load: false,
            hasErrors: {},
            kategori: '',
            kategori2: [],
            categories: [],
            category: [],
            notFound: false,
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
    beforeCreate(){
        axios.get('/api/auth/init').then(data => {
            if(!data.data.isAdmin){
                this.$router.push('/auth/signin');
            }
        })
    },
    mounted(){
        this.getProducts();
        axios.get('/api/kategori/index').then(data => {
            this.kategori2.push({text: 'Semua', value: ''});
            for(let v in data.data){
                this.kategori2.push({text: data.data[v].nama_kategori, value: data.data[v].slug});
                this.categories.push({text: data.data[v].nama_kategori, value: data.data[v].slug});
            }
        });
        this.show();
    },
    watch: {
        id_product: function(){
            this.show();
        }
    },
    methods: {
        getProducts(){
            axios.get(`/api/product/index/${this.kategori}`).then(data => {
                this.products = data.data.data;
                this.first = false
            })
        },
        show(){
            if (this.id_product) {
                this.load = true;
                axios.get(`/api/product/index/${this.id_product}/show`).then(res => {
                    var input = res.data.data;
                    this.input.id = input.id;
                    this.input.nama = input.nama;
                    this.input.singkatan = input.singkatan;
                    this.input.harga = input.harga;
                    this.input.kategori = input.slug;
                    this.input.oldGambar = input.link;
                    this.cek(input.slug, input.detail.split('-'));
                    this.load = false;
                }).catch(e => {
                    this.load = false;
                    this.notFound = true;
                })
            }
        },
        cari(){
            if(this.search){
                var kategori = this.kategori? this.kategori : 'all';
                axios.get(`/api/product/search/${kategori}/${this.search}`).then(data => {
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
            data.append('id', this.input.id);
            data.append('nama', this.input.nama);
            data.append('singkatan', this.input.singkatan);
            data.append('harga', this.input.harga);
            data.append('kategori', this.input.kategori);
            data.append('detail', this.input.detail);
            data.append('gambar', this.input.gambar);

            var config = {
                headers: {'content-type': 'multipart/form-data'}
            }

            this.loading = true;
            axios.post('/api/admin/edit-product', data, config).then(res => {
                this.$swal.fire({
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-end',
                    icon: res.data.type,
                    title: res.data.message,
                    timer: 3000,
                    timerProgressBar: true
                })
                this.getProducts()
                this.loading = false;
                this.$router.push('/admin/edit-product');
            }).catch(e => {
                this.loading = false;
                this.hasErrors = e.response.data.errors
            })
        },
        hapus(id){
            this.$swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Jika iya, tekan tombol 'Ya'!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                axios.post(`/api/admin/delete/`, {id: id}).then((respon) => {
                    this.getProducts();
                    this.$swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: respon.data.type,
                        title: respon.data.message,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    })
                });
                }
            })
        }
    }
}
</script>

<style>

</style>
