<template>
  <v-container>
      <stok-loader v-if="first && id_product"></stok-loader>
      <template v-else-if="first">
          <v-row>
              <v-col cols="12" class="mt-2">
                  <v-skeleton-loader class="title" width="430" type="heading"></v-skeleton-loader>
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
            <div class="title col-12">Tambah Stok Barang</div>
            <v-col cols="7" md="9">
                <v-text-field v-model="search" @keyup="cari()" hide-details="" label="cari barang.."></v-text-field>
            </v-col>
            <v-col cols="5" md="3">
                <v-select :items="categories" @change="getProducts" v-model="kategori" hide-details="" label="Sort Kategori"></v-select>
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
                                            <v-col cols="5" md="7">
                                                {{product.nama}}
                                                <v-subheader v-text="product.stok_kata"></v-subheader>
                                            </v-col>
                                            <v-col cols="3" md="2">
                                                <v-btn small text color="success" :to="{name: 'admin.stok', params: {id_product: product.id}}"><v-icon left>mdi-plus-circle</v-icon>Tambah</v-btn>
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
            <stok-view :id_product="id_product"></stok-view>
        </v-row>
      </template>
  </v-container>
</template>

<script>
import StokView from './StokView.vue';
import StokLoader from './StokLoader.vue';
export default {
    components: {'stok-view': StokView, 'stok-loader': StokLoader},
    props: ['id_product'],
    data(){
        return{
            first: true,
            products: {},
            search: '',
            kategori: '',
            categories: [],
            notFound: false,
        }
    },
    beforeCreate(){
        axios.get('/api/auth/init').then(data => {
            if(!data.data.isAdmin){
                this.$router.push('/auth/signin');
            }
        })
    },
    watch: {
        id_product: function(){
            this.getProducts();
        }
    },
    mounted(){
        this.getProducts();
        axios.get('/api/kategori/index').then(data => {
            this.categories.push({text: 'Semua', value: ''});
            for(let v in data.data){
                this.categories.push({text: data.data[v].nama_kategori, value: data.data[v].slug});
            }
        });
    },
    methods: {
        getProducts(){
            axios.get(`/api/product/index/${this.kategori}`).then(data => {
                this.products = data.data.data;
                this.first = false
            })
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
    }
}
</script>

<style>

</style>
