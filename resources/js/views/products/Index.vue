<template>
    <v-container class="mt-3">
        <v-row>
            <v-col cols="12">
                <v-text-field dense hide-details="" outlined rounded v-model="vsearch" @keyup="search" append-icon="mdi-magnify" label="Cari barang" @click:append="search()"></v-text-field>
            </v-col>
            <v-col md="3" cols="12" class="d-none d-md-block">
                <kategori :active="active"></kategori>
                <cart></cart>
            </v-col>
            <v-col md="9" cols="12">
                <v-row>
                    <template v-if="products.length > 0">
                    <v-col cols="6" md="3" v-for="product in products" :key="product.id">
                            <v-card>
                                <router-link :to="{name: 'product.detail', params: {id: product.id, category: product.slug}}" style="text-decoration: none">
                                    <v-img :src="`/img/barang/${product.gambar}`" class="white--text align-end" gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)" height="200px" >
                                    <v-card-title v-text="product.nama"></v-card-title>
                                    </v-img>
                                </router-link>

                                <v-card-actions>
                                    <v-btn icon>
                                        <v-icon>mdi-heart</v-icon>
                                    </v-btn>

                                    <v-spacer></v-spacer>

                                    <v-btn icon>
                                        <v-icon>mdi-share-variant</v-icon>
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                    </v-col>
                    </template>
                    <template v-else>
                        <v-col cols="12">
                            <v-alert color="warning" outlined>
                                <v-icon>mdi-info</v-icon>
                                Tidak ditemukan barang!
                            </v-alert>
                        </v-col>
                    </template>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import Category from '../../components/Category.vue';
export default {
    props: ['category'],
    data(){
        return{
            products: {},
            active: '',
            vsearch: ''
        }
    },
    watch:{
        category: function (){
            this.getProducts();
        }
    },
    mounted(){
        this.getProducts();
    },

    methods: {
        getProducts(){
            var category = this.category ? this.category : '';
            this.active = category;
            axios.get(`/api/product/index/${category}`).then((response) => {
                this.products = response.data.data;
            });
        },
        search(){
            var category = this.category ? this.category : 'all';
            if(this.vsearch){
                axios.get(`/api/product/search/${category}/${this.vsearch}`).then(res => {
                    this.products = res.data.data
            });
            }else{
                this.getProducts();
            }
        }
    }
}
</script>
