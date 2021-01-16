<template>
    <v-container class="mt-3">
        <template v-if="first">
            <v-row>
                <v-col cols="12" class="mt-3" v-if="!id">
                    <v-skeleton-loader type="text"></v-skeleton-loader>
                </v-col>
                <v-col cols="12" md="3" class="d-none d-md-block">
                    <v-card>
                        <v-skeleton-loader type="list-item"></v-skeleton-loader>
                        <v-divider></v-divider>
                        <v-skeleton-loader type="list-item@6"></v-skeleton-loader>
                    </v-card>
                    <v-card class="mt-4">
                        <v-skeleton-loader type="list-item"></v-skeleton-loader>
                        <v-divider></v-divider>
                        <v-skeleton-loader type="list-item@6"></v-skeleton-loader>
                    </v-card>
                </v-col>
                <v-col md="9" cols="12">
                    <v-row v-if="!id">
                        <v-col cols="6" md="3" v-for="i in 12" :key="i">
                            <v-skeleton-loader type="image"></v-skeleton-loader>
                        </v-col>
                    </v-row>
                    <show-loader v-else></show-loader>
                </v-col>
            </v-row>
        </template>
        <template v-else>
        <v-row>
            <v-col cols="12" v-if="!id">
                <v-text-field dense hide-details="" outlined rounded v-model="vsearch" @keyup="search" append-icon="mdi-magnify" label="Cari barang" @click:append="search()"></v-text-field>
            </v-col>
            <v-col md="3" cols="12" class="d-none d-md-block">
                <kategori :active="active"></kategori>
                <cart></cart>
            </v-col>
            <v-col md="9" cols="12">
                <v-row v-if="!id">
                    <template v-if="load">
                        <v-col cols="6" md="3" v-for="i in 12" :key="i">
                            <v-skeleton-loader type="image"></v-skeleton-loader>
                        </v-col>
                    </template>
                    <template v-else-if="products.length > 0">
                    <v-col cols="6" md="3" v-for="product in products" :key="product.id">
                            <v-card>
                                <router-link :to="{name: 'product', params: {id: product.id, category: product.slug}}" style="text-decoration: none">
                                    <v-img :src="product.link" class="white--text align-end" gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)" height="200">
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
                <show v-else></show>
            </v-col>
        </v-row>
        </template>
    </v-container>
</template>

<script>
import Category from '../../components/Category.vue';
import Show from './Show.vue';
import Loader from './ShowLoader.vue';
export default {
    components: {Show, 'show-loader': Loader},
    props: ['category', 'id'],
    data(){
        return{
            first: true,
            load: false,
            products: {},
            active: '',
            vsearch: ''
        }
    },
    watch:{
        category: function (){
            this.load = true;
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
                this.first = false;
                this.load = false;
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
