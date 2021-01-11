<template>
<div class="container mt-3">
    <v-row v-if="!id_buyer">
        <v-col cols="12" md="8" class="mb-3">
            <v-card>
                <v-list>
                    <v-list-item-group>
                        <v-list-item disabled color="primary">
                            <v-list-item-title>
                                <v-icon color="primary">mdi-message</v-icon>
                                Pesanan 1
                            </v-list-item-title>
                        </v-list-item>
                        <v-divider></v-divider>
                        <template v-for="(cart, index) in carts">
                            <v-list-item :key="index"
                                        :to="{name: 'admin', params: {id_buyer: cart.id_buyer}}"
                                        :disabled="cart.kode_pesan == 1? true : false">
                                <v-list-item-title :class="[{'d-flex justify-space-between': true}, info_pesan[cart.kode_pesan -1]]">
                                    <span v-text="cart.nama"></span>
                                    <span v-text="'Rp. '+number_format(cart.total_harga)"></span>
                                </v-list-item-title>
                            </v-list-item>
                            <v-divider :key="cart.nama"></v-divider>
                        </template>
                        <v-list-item disabled class="primary--text">
                            <v-list-item-title class="d-flex justify-space-between">
                                <span>Jumlah Pesanan</span> {{carts.length}}
                            </v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-card>
        </v-col>
        <v-col md="4" cols="12">
            <v-card>
                <v-list>
                    <v-list-item-group>
                        <v-list-item class="white--text">Status Pesanan</v-list-item>
                        <!-- <v-divider></v-divider> -->
                        <v-list-item class="lighten-3 red" light>
                            <v-list-item-title class="red--text">Pesanan Belum Dibayar</v-list-item-title>
                        </v-list-item>
                        <!-- <v-divider></v-divider> -->
                        <v-list-item class="lighten-3 warning" light>
                            <v-list-item-title class="warning--text">Pesanan Sedang Dikerjakan</v-list-item-title>
                        </v-list-item>
                        <!-- <v-divider></v-divider> -->
                        <v-list-item class="lighten-3 primary" light>
                            <v-list-item-title class="primary--text">Pesanan Siap Diambil/antar</v-list-item-title>
                        </v-list-item>
                        <!-- <v-divider></v-divider> -->
                        <v-list-item class="lighten-3 success" light>
                            <v-list-item-title class="success--text">Pesanan Sudah Sampai ke Pembeli</v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-card>
        </v-col>
    </v-row>
    <div class="row" v-if="id_buyer">
        <div class="col-12 col-md-7 border-info mb-3">
            <div class="collapse show" id="keranjang2">
                <li class="list-group-item bg-info text-white">
                    <h5><i class="fas fa-cart"></i> {{ carts.nama}}</h5>
                </li>
                <li class="list-group-item d-flex justify-content-between" v-for="v in carts.products" :key="v.id_buyer">
                    <span>
                        {{ v.jml_beli }} <b>{{ v.nama_barang }}</b> {{ ' ('+v.harga_barang+") "}}
                    </span>
                    <span class="h5">
                        Rp. {{number_format(v.jml_harga) }}
                    </span>
                </li>
                <li class="list-group-item bg-gray-300 d-flex justify-content-between">
                    <span>
                        Ongkir
                    </span>
                    <span class="h5">
                        Rp. {{number_format(carts.ongkir) }}
                    </span>
                </li>
                <li class="list-group-item bg-info text-white d-flex justify-content-between">
                    <span>
                        Total harga
                    </span>
                    <span class="h5">
                        Rp. {{number_format(carts.total_harga)}}
                    </span>
                </li>
            </div>
        </div>
        <div class="col-12 col-md-5 mb-3">
            <div class="collapse show">
                <li class="list-group-item bg-info text-white">Info pembeli</li>
                <li class="list-group-item">{{ carts.nama}}</li>
                <li class="list-group-item">{{ carts.email}}</li>
                <li class="list-group-item">{{ carts.telepon}}</li>
                <li class="list-group-item">{{ carts.alamat}}</li>
                <li class="list-group-item">{{ carts.catatan}}</li>
            </div>
        </div>
        <div class="col-12 col-md-7">
            <form action="#" method="post">
                <button class="btn btn-success col-12">Print Struk</button>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import number_format from '../../number_format';
export default {
    props: ['id_buyer'],
    data(){
        return{
            carts: {},
            kelas: {},
            number_format,
            info_pesan: ['red--text', 'warning--text', 'primary--text', 'success--text']
        }
    },
    watch: {
        id_buyer: function(){
            this.getCarts();
        }
    },
    computed: {
        user(){
            return this.$store.state.user;
        }
    },
    mounted(){
        this.getCarts();
    },
    methods: {
        async getCarts(){
            try{
                var id_buyer = this.id_buyer ? this.id_buyer : '';
                var response = await axios.get(`/api/admin/getCarts/${id_buyer}`);
                this.carts = response.data.data;
                var kelas = ['list-group-item-danger', 'list-group-item-warning', 'list-group-item-primary' , 'list-group-item-success'];
                for(var key in this.carts){
                    this.kelas[key] = kelas[this.carts[key].kode_pesan -1];
                }
            }catch(e){this.$router.push('/')}
        }
    }
}
</script>

<style>

</style>
