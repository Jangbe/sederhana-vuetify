<template>
<v-container>
    <v-row v-if="first">
        <v-col cols="12" md="8" class="mt-2">
            <v-list>
                <v-card>
                    <v-list-item>
                        <v-list-item-title>
                            <v-skeleton-loader width="300" type="heading"></v-skeleton-loader>
                        </v-list-item-title>
                    </v-list-item>
                    <v-divider></v-divider>
                    <v-skeleton-loader type="list-item@10"></v-skeleton-loader>
                </v-card>
            </v-list>
        </v-col>
        <v-col cols="12" md="4" class="mt-2">
            <v-list>
                <v-card>
                    <v-list-item>
                        <v-list-item-title>
                            <v-skeleton-loader width="330" type="heading"></v-skeleton-loader>
                        </v-list-item-title>
                    </v-list-item>
                    <v-divider></v-divider>
                    <v-skeleton-loader type="list-item@4"></v-skeleton-loader>
                </v-card>
            </v-list>
        </v-col>
    </v-row>
    <v-row v-else-if="!id_buyer">
        <v-col cols="12" md="8">
            <v-list>
                <v-card>
                    <v-list-item-group>
                        <v-list-item disabled color="primary">
                            <v-list-item-title>
                                <v-icon color="primary" left>mdi-message</v-icon>
                                Pesanan 1
                            </v-list-item-title>
                        </v-list-item>
                        <v-divider></v-divider>
                        <template v-for="(cart, index) in carts">
                            <v-list-item :key="index"
                                        :to="{name: 'admin', params: {id_buyer: cart.id_buyer}}"
                                        :disabled="cart.kode_pesan == 1? true : false"
                                        :class="['lighten-3', info_pesan[cart.kode_pesan -1]]">
                                <v-list-item-title :class="['d-flex justify-space-between', info_pesan[cart.kode_pesan -1]+'--text']">
                                    <span v-text="cart.nama"></span>
                                    <span v-text="'Rp. '+number_format(cart.total_harga)"></span>
                                </v-list-item-title>
                            </v-list-item>
                            <v-divider :key="cart.nama" :class="[info_pesan[cart.kode_pesan -1]]"></v-divider>
                        </template>
                        <v-list-item disabled class="primary--text">
                            <v-list-item-title class="d-flex justify-space-between">
                                <span>Jumlah Pesanan</span> {{carts.length}}
                            </v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-card>
            </v-list>
        </v-col>
        <v-col md="4" cols="12">
            <v-list disabled>
                <v-card>
                    <v-list-item-group>
                        <v-list-item>
                            <v-list-item-title class="primary--text">Status Pesanan</v-list-item-title></v-list-item>
                        <v-divider></v-divider>
                        <v-list-item class="lighten-3 red" light>
                            <v-list-item-title class="red--text">Pesanan Belum Dibayar</v-list-item-title>
                        </v-list-item>
                        <v-divider class="red"></v-divider>
                        <v-list-item class="lighten-3 warning" light>
                            <v-list-item-title class="warning--text">Pesanan Sedang Dikerjakan</v-list-item-title>
                        </v-list-item>
                        <v-divider class="warning"></v-divider>
                        <v-list-item class="lighten-3 primary" light>
                            <v-list-item-title class="primary--text">Pesanan Siap Diambil/antar</v-list-item-title>
                        </v-list-item>
                        <v-divider class="primary"></v-divider>
                        <v-list-item class="lighten-3 success" light>
                            <v-list-item-title class="success--text">Pesanan Sudah Sampai ke Pembeli</v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-card>
            </v-list>
        </v-col>
    </v-row>
    <v-row v-if="id_buyer">
        <v-col cols="12" md="8">
            <v-list disabled>
                <v-card>
                    <v-list-item-group>
                        <v-list-item class="light-blue">
                            <v-list-item-title class="white--text"><v-icon class="white--text" left>mdi-cart</v-icon> {{ carts.nama}}</v-list-item-title>
                        </v-list-item>
                        <template v-for="(v, k) in carts.products">
                            <v-list-item :key="k+'-text'">
                                <v-list-item-title class="d-flex justify-space-between">
                                    <span>
                                        {{ v.jml_beli }} <b>{{ v.nama_barang }}</b> {{ ' ('+v.harga_barang+") "}}
                                    </span>
                                    <span class="h5">
                                        Rp. {{number_format(v.jml_harga) }}
                                    </span>
                                </v-list-item-title>
                            </v-list-item>
                            <v-divider v-if="k + 1 < carts.products.length" :key="k"></v-divider>
                        </template>
                        <v-list-item class="light-blue lighten-3">
                            <v-list-item-title class="d-flex justify-space-between white--text">
                                <span>
                                    Ongkir
                                </span>
                                <span class="h5">
                                    Rp. {{number_format(carts.ongkir) }}
                                </span>
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item class="light-blue">
                            <v-list-item-title class="d-flex justify-space-between white--text">
                                <span>
                                    Total harga
                                </span>
                                <span class="h5">
                                    Rp. {{number_format(carts.total_harga) }}
                                </span>
                            </v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
            </v-card>
                </v-list>
        </v-col>
        <v-col cols="12" md="4">
            <v-list>
                <v-card>
                    <v-list-item class="light-blue"><v-list-item-title class="white--text">Info pembeli</v-list-item-title></v-list-item>
                    <v-list-item>{{ carts.nama}}</v-list-item><v-divider></v-divider>
                    <v-list-item>{{ carts.telepon}}</v-list-item><v-divider></v-divider>
                    <v-list-item>{{ carts.alamat}}</v-list-item><v-divider></v-divider>
                    <v-list-item>{{ carts.catatan}}</v-list-item>
                </v-card>
            </v-list>
        </v-col>
        <v-col cols="12" md="12">
            <form action="#" method="post">
                <v-btn color="success" class="col-12">Print Struk</v-btn>
            </form>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
import number_format from '../../number_format';
export default {
    props: ['id_buyer'],
    data(){
        return{
            first: true,
            carts: {},
            number_format,
            info_pesan: ['red', 'warning', 'primary', 'success']
        }
    },
    watch: {
        id_buyer: function(){
            this.first = true;
            this.getCarts();
        }
    },
    computed: {
        user(){
            return this.$store.state.user;
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
        this.getCarts();
    },
    methods: {
        async getCarts(){
            var id_buyer = this.id_buyer ? this.id_buyer : '';
            var response = await axios.get(`/api/admin/getCarts/${id_buyer}`);
            this.carts = response.data.data;
            this.first = false;
        }
    }
}
</script>

<style>

</style>
