<template>
  <v-container>
      <template v-if="first">
          <v-row>
              <v-skeleton-loader class="title col-4 mt-2" type="heading"></v-skeleton-loader>
              <v-col cols="7" md="9" class="mt-6">
                  <v-skeleton-loader type="text"></v-skeleton-loader>
              </v-col>
              <v-col cols="5" md="3" class="mt-6">
                  <v-skeleton-loader type="text"></v-skeleton-loader>
              </v-col>
              <v-col cols="12" class="mt-4">
                  <v-card>
                      <v-skeleton-loader type="table-thead"></v-skeleton-loader>
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
      </template>
  </v-container>
</template>

<script>
export default {
    props: ['id_product'],
    data(){
        return{
            first: true,
            products: {},
            search: '',
            loading: false,
            hasErrors: {},
            kategori: '',
            kategori2: [],
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
                axios.get(`/api/product/index/${this.id_product}/show`).then(res => {
                    var input = res.data.data;
                    this.input.id = input.id;
                    this.input.nama = input.nama;
                    this.input.singkatan = input.singkatan;
                    this.input.harga = input.harga;
                    this.input.kategori = input.slug;
                    this.input.oldGambar = input.gambar;
                    this.cek(input.slug, input.detail.split('-'));
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
                this.$router.push('/admin/edit-product');
            }).catch(e => {
                this.hasErrors = e.response.data.errors
            })
        }
    }
}
</script>

<style>

</style>
